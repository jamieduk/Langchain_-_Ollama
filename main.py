#
# (c) J~Net 2024
#
#
# python main.py
#
import json
import time
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

def get_response(question):
    """Gets the response from the cache or the model."""
    if question in cache:
        start_time=time.time()
        response=cache[question]
        end_time=time.time()

        # Calculate time taken to retrieve from cache
        elapsed_time=end_time - start_time
        print(Fore.CYAN + f"Response retrieved from cache! Time taken: {elapsed_time:.6f} seconds" + Style.RESET_ALL)

        return response

    # Start timer for LLM response
    start_time=time.time()

    # Get the response from the LLM
    response=chain.invoke({"question": question})

    # End timer for LLM response
    end_time=time.time()

    # Cache the response
    cache[question]=response
    save_cache()

    # Calculate and print time taken for LLM response
    elapsed_time=end_time - start_time
    print(f"LLM response time: {elapsed_time:.6f} seconds")

    return response

# Main loop
try:
    while True:
        question=input("Ask a question (or type 'exit' to quit): ")

        if question.lower() == "exit":
            break

        # Get the response (from cache or LLM)
        response=get_response(question)

        # Print the response in green
        print(Fore.GREEN + response + Style.RESET_ALL)

finally:
    # Save cache on exit
    save_cache()

