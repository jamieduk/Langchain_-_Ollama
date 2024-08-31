# main.py (Modified to accept input via command-line arguments)
import json
import time
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

def get_response(question):
    """Gets the response from the cache or the model."""
    if question in cache:
        response=cache[question]
        return response

    # Get the response from the LLM
    response=chain.invoke({"question": question})

    # Cache the response
    cache[question]=response
    save_cache()

    return response

# Accept input from command-line arguments
if len(sys.argv) > 1:
    question=" ".join(sys.argv[1:])
    response=get_response(question)
    print(response)
else:
    print("No question provided.")

