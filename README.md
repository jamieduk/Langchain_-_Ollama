# Langchain & Ollama By J~Net 2024

Welcome to the **Langchain & Ollama** integration by J~Net. This guide will walk you through setting up Langchain with Ollama models, along with tips for running the app, caching responses, and multi-modal usage.

## Links
- GitHub: [Langchain & Ollama Integration](https://github.com/jamieduk/Langchain_-_Ollama)
- Langchain Documentation: [Langchain Ollama Integration](https://python.langchain.com/v0.2/docs/integrations/llms/ollama)

LangChain 0.2 is out! Leave feedback on the [v0.2 docs here](https://python.langchain.com/v0.2/docs/). You can view the v0.1 docs [here](https://python.langchain.com/v0.1/docs/).

## 🦜️🔗 LangChain and Ollama Overview

This guide goes over how to use LangChain to interact with Ollama models.

### Installation

Make sure you are in a virtual environment before installing the dependencies. Create and activate a virtual environment with:

```bash
# Create virtual environment (if not already created)
python -m venv venv

# Activate virtual environment
# For Windows:
venv\Scripts\activate
# For Mac/Linux:
source venv/bin/activate
Now, install the necessary packages:

bash
Copy code
# Install packages
pip install -U langchain-ollama
pip install colorama
Alternatively, install from the requirements file:

bash
Copy code
pip install -r requirements.txt
If you need Ollama, follow these instructions to set up and run a local Ollama instance:

bash
Copy code
curl -fsSL https://ollama.com/install.sh | sh
Ollama Setup and Model Management
Download and Install Ollama:
Download and install Ollama onto the supported platforms, including Windows Subsystem for Linux (WSL).

Fetch LLM Models:
To fetch an available LLM model, run:

bash
Copy code
ollama pull <name-of-model>
Example:

bash
Copy code
ollama pull llama3
This will download the default tagged version of the model. By default, it will pull the latest, smallest sized-parameter model.

View Pulled Models:
To view all pulled models, use:

bash
Copy code
ollama list
Chat Directly with a Model:
Use the following command to chat directly with a model from the command line:

bash
Copy code
ollama run <name-of-model>
Refer to the Ollama documentation for more commands. You can also run ollama help in the terminal to see available commands.

Model Storage Locations
On Mac, models are stored at ~/.ollama/models.
On Linux or WSL, models are stored at /usr/share/ollama/.ollama/models.
Example Usage with LangChain and Ollama
The following is an example of using LangChain and Ollama to run a simple LLM query:

python
Copy code
from langchain_core.prompts import ChatPromptTemplate
from langchain_ollama.llms import OllamaLLM

template = """Question: {question}

Answer: Let's think step by step."""

prompt = ChatPromptTemplate.from_template(template)

model = OllamaLLM(model="llama3.1")

chain = prompt | model

response = chain.invoke({"question": "What is LangChain?"})
print(response)
Running the App
You can execute the app using:

bash
Copy code
python test.py
Or:

bash
Copy code
python main.py
Multi-Modal Support with Ollama
Ollama has support for multi-modal LLMs, such as bakllava and llava. To use a multi-modal model, download the model as follows:

bash
Copy code
ollama pull bakllava
Ensure that you update Ollama to the latest version to support multi-modal functionalities.

Working with Images and Base64 Encoding
Ollama also supports working with images in multi-modal models. Below is an example of how to display a Base64-encoded image using Python:

python
Copy code
import base64
from io import BytesIO
from IPython.display import HTML, display
from PIL import Image

def convert_to_base64(pil_image):
    """
    Convert PIL images to Base64 encoded strings.
    :param pil_image: PIL image
    :return: Re-sized Base64 string
    """
    buffered = BytesIO()
    pil_image.save(buffered, format="JPEG")  # Change format as needed
    img_str = base64.b64encode(buffered.getvalue()).decode("utf-8")
    return img_str

def plt_img_base64(img_base64):
    """
    Display base64 encoded string as an image.
    :param img_base64: Base64 string
    """
    image_html = f'<img src="data:image/jpeg;base64,{img_base64}" />'
    display(HTML(image_html))

file_path = "../../../static/img/ollama_example_img.jpg"
pil_image = Image.open(file_path)
image_b64 = convert_to_base64(pil_image)
plt_img_base64(image_b64)
Feedback and Contributions
Feel free to contribute to the project or provide feedback on the GitHub repository.

Langchain & Ollama Integration by J~Net, 2024.

markdown
Copy code

### Explanation:

- **Title and Introduction**: Provides context for the project.
- **Installation**: Includes instructions for setting up a virtual environment, installing dependencies, and setting up Ollama.
- **Ollama Setup**: Explains how to pull models, store them, and use them in chat interactions.
- **Code Examples**: Demonstrates usage of Langchain with Ollama for both text-based LLMs and multi-modal capabilities.
- **Running the App**: Shows how to execute the app via Python scripts.
- **Image Processing**: A multi-modal example for working with Base64 images.
- **Feedback Section**: Encourages contributions and feedback.

This Markdown file should work well as documentation for your repository!
