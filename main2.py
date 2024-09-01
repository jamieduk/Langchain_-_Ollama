#
# (c) J~Net 2024
# https://github.com/jamieduk/Langchain_-_Ollama
#
# python main.py
#
import json
import time
import os
import signal
import sys
from langchain_core.prompts import ChatPromptTemplate
from langchain_ollama.llms import OllamaLLM
from colorama import Fore, Style, init

# Initialize colorama
init()

# Define the prompt template
template="""Question: {question}

Answer: Let's think step by step."""

prompt=ChatPromptTemplate.from_template(template)

# Use the smaller 'crewai-tinyllama' model
model=OllamaLLM(model="crewai-tinyllama:latest")

# Create the chain
chain=prompt | model

# Simple cache storage
CACHE_FILE="question_cache.json"

# Load cache from the file
try:
    with open(CACHE_FILE, "r") as f:
        cache=json.load(f)
except FileNotFoundError:
    cache={}

def save_cache():
    """Saves the current cache to the file."""
    with open(CACHE_FILE, "w") as f:
        json.dump(cache, f)

def scrape_news():
    """Runs Scrapy spider to scrape news and return the latest headlines."""
    print(Fore.YELLOW + "Fetching the latest news..." + Style.RESET_ALL)
    
    try:
        os.system('python scrapy_news_spider.py')
    except Exception as e:
        return f"Failed to execute Scrapy spider: {str(e)}"
    
    # Ensure the file exists before attempting to read it
    if not os.path.exists('news.json'):
        return "News file not found. Unable to fetch news."
    
    # Read the scraped data
    try:
        with open('news.json', 'r') as f:
            file_content=f.read().strip()
            if file_content == '':
                return "News file is empty. Unable to fetch news."

            # Debug output
            print("Debug: File content before parsing:", file_content)

            # Split the content to handle extra data
            json_objects=file_content.split('}\n{')
            json_objects=['{' + obj + '}' if i > 0 else obj for i, obj in enumerate(json_objects)]
            
            # Process only the first valid JSON object
            data=json.loads(json_objects[0])
        
        headlines=data.get('headlines', [])
        
        # Return top 5 headlines
        return "\n".join(headlines[:5]) if headlines else "No relevant news found."
    except json.JSONDecodeError as e:
        return f"Failed to read scraped news: {str(e)}"
    except Exception as e:
        return f"Failed to read scraped news: {str(e)}"

def get_response(question):
    """Gets the response from the cache, the model, or scrapes if needed."""
    if "news" in question.lower():
        print(Fore.YELLOW + "Fetching the latest news..." + Style.RESET_ALL)
        response=scrape_news()
    else:
        start_time=time.time()
        response=chain.invoke({"question": question})
        end_time=time.time()
        elapsed_time=end_time - start_time
        print(f"LLM response time: {elapsed_time:.6f} seconds")
        if "I'm not sure" in response or len(response.strip()) < 50:
            print(Fore.YELLOW + "LLM unsure, attempting to scrape web data..." + Style.RESET_ALL)
            response=scrape_news()
        
        # Save response to cache only if it's not related to news
        cache[question]=response
        save_cache()
    
    return response

def signal_handler(sig, frame):
    """Handle exit signals (Ctrl+C)"""
    print("\nExiting gracefully...")
    sys.exit(0)

# Set up signal handling
signal.signal(signal.SIGINT, signal_handler)

# Main loop
try:
    while True:
        question=input("Ask a question (or type 'exit' to quit): ")

        if question.lower() == "exit":
            break

        response=get_response(question)
        print(Fore.GREEN + response + Style.RESET_ALL)

finally:
    save_cache()

