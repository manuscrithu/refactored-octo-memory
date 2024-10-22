# refactored-octo-memory
This is a personal, in-browser university GPA calculator for undergraduates. This is an external web application which can be accessed via university's official LMS.
# GPA Calculator Web Application

## Overview
The GPA Calculator is a web application designed to simplify the process of retrieving and calculating students' GPAs. By entering their unique usernames (e.g., `ICT/21/940`, `EGT/20/123`), students can view their academic performance results directly from the database. 

## Features
- **User-Friendly Interface**: Simple and intuitive form to input usernames.
- **Real-Time GPA Calculation**: Fetches data from the database and calculates GPA instantly.
- **Pattern Validation**: Ensures that the entered username follows a specific format to avoid errors.
- **Secure Backend**: Efficiently handles data retrieval and processing with Express and MongoDB.

## Technology Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: Express.js, PHP
- **Database**: MongoDB
- **Others**: JSON, AJAX

## Installation
To run this project locally, follow the steps below:

1. **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd gpa-calculator
    ```

2. **Install dependencies:**
    ```bash
    npm install
    ```

3. **Set up the MongoDB database:**
    - Create a MongoDB database.
    - Import your student data and mark sheets.

4. **Run the application:**
    ```bash
    npm start
    ```
    
5. **Access the app:**
    - Open your browser and navigate to `http://localhost:3000`.

## Usage
1. Open the application in your browser.
2. Enter your student username in the format:
    - `ICT/XX/XXX` (e.g., `ICT/21/940`)
    - `EGT/XX/XXX` (e.g., `EGT/19/123`)
    - `BST/XX/XXX` (e.g., `BST/22/456`)
3. Click on **Check GPA**.
4. View your GPA results.

## Project Structure
gpa-calculator/ │ ├── backEnd/ │ ├── viewResult.php │ └── ... ├── frontEnd/ │ ├── index.html │ └── ... ├── routes/ │ ├── api.js │ └── ... ├── public/ │ ├── css/ │ └── js/ │ ├── package.json ├── server.js └── README.md


## Contributing
Feel free to fork the repository and submit pull requests. Contributions, issues, and feature requests are welcome!

1. Fork the project
2. Create your feature branch: `git checkout -b feature/your-feature`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature/your-feature`
5. Open a pull request

## Contact
For any queries, please contact [Bhanuka Wickramasinghe](mailto:bhanuwick426@gmail.com).
