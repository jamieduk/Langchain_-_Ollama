from langchain_core.prompts import ChatPromptTemplate
from langchain_ollama.llms import OllamaLLM

# Define the prompt template
template="""Question: {question}

Answer: Let's think step by step."""

# Create the prompt template object
prompt=ChatPromptTemplate.from_template(template)

# Use the verified model 'crewai-tinyllama'
model=OllamaLLM(model="crewai-tinyllama:latest")

# Create the chain
chain=prompt | model

# Invoke the chain with a question
try:
    response=chain.invoke({"question": "What is LangChain?"})
    print(response)  # Print the response from the model
except Exception as e:
    print(f"Error occurred: {e}")



