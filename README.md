# Quiz App API Documentation

## Overview
This is the API documentation for the **Quiz App**, which allows users to register, log in, create quizzes, answer questions, and view results.

## Base URL
```
http://brighte4.beget.tech/

```

## Authentication
Some endpoints require authentication using a Bearer token.

---

## 📌 User Endpoints

### 🔹 1. Register User
**Endpoint:** `POST /api/register`  
**Description:** Registers a new user.  
**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```
**Response:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

### 🔹 2. Login
**Endpoint:** `POST /api/login`  
**Description:** Logs in a user and returns an authentication token.  
**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```
**Response:**
```json
{
  "token": "your_jwt_token"
}
```

### 🔹 3. Get User Info (Authenticated)
**Endpoint:** `GET /api/users/getInfo`  
**Auth:** ✅ Required (Bearer token)  
**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com"
}
```

---

## 📌 Quiz Endpoints

### 🔹 4. Create a Quiz (Authenticated)
**Endpoint:** `POST /api/quizzes`  
**Auth:** ✅ Required  
**Request Body:**
```json
{
  "title": "General Knowledge Quiz",
  "description": "A quiz about general knowledge",
  "questions": [
    { "question": "What is the capital of France?", "answer": "Paris" },
    { "question": "Who wrote 'Hamlet'?", "answer": "William Shakespeare" }
  ]
}
```
**Response:**
```json
{
  "message": "Quiz created successfully",
  "quiz_id": 1
}
```

### 🔹 5. Get All Quizzes
**Endpoint:** `GET /api/quizzes`  
**Auth:** ✅ Required  
**Response:**
```json
[
  {
    "id": 1,
    "title": "General Knowledge Quiz",
    "description": "A quiz about general knowledge"
  }
]
```

### 🔹 6. Get Quiz by ID
**Endpoint:** `GET /api/quizzes/{id}`  
**Auth:** ✅ Required  
**Response:**
```json
{
  "id": 1,
  "title": "General Knowledge Quiz",
  "description": "A quiz about general knowledge",
  "questions": [
    { "id": 1, "question": "What is the capital of France?" },
    { "id": 2, "question": "Who wrote 'Hamlet'?" }
  ]
}
```

### 🔹 7. Update a Quiz
**Endpoint:** `PUT /api/updatequiz/{id}`  
**Auth:** ✅ Required  
**Request Body:**
```json
{
  "title": "Updated Quiz Title",
  "description": "Updated description"
}
```
**Response:**
```json
{
  "message": "Quiz updated successfully"
}
```

### 🔹 8. Delete a Quiz
**Endpoint:** `DELETE /api/quizzes/{id}`  
**Auth:** ✅ Required  
**Response:**
```json
{
  "message": "Quiz deleted successfully"
}
```

---

## 📌 Answer Endpoints

### 🔹 9. Submit an Answer
**Endpoint:** `POST /api/answers`  
**Auth:** ✅ Required  
**Request Body:**
```json
{
  "quiz_id": 1,
  "question_id": 2,
  "answer": "William Shakespeare"
}
```
**Response:**
```json
{
  "message": "Answer submitted successfully",
  "correct": true
}
```

---

## 📌 Result Endpoints

### 🔹 10. Submit a Quiz Result
**Endpoint:** `POST /api/results`  
**Auth:** ✅ Required  
**Request Body:**
```json
{
  "quiz_id": 1,
  "user_id": 1,
  "score": 80
}
```
**Response:**
```json
{
  "message": "Result saved successfully",
  "result_id": 1
}
```

### 🔹 11. Get Quiz by Unique Value
**Endpoint:** `GET /api/quizzes/{id}/getByUniqueValue`  
**Auth:** ✅ Required  
**Response:**
```json
{
  "id": 1,
  "title": "General Knowledge Quiz",
  "description": "A quiz about general knowledge",
  "unique_value": "quiz_12345"
}
```

---

## 🚀 Installation & Setup

1️⃣ **Clone the Repository:**
```sh
git clone https://github.com/maftunaShukhratovna/quiz-app.git
cd quiz-app
```

2️⃣ **Install Dependencies:**
```sh
composer install
```
---

## 📞 Support
If you have any issues, feel free to contact the developer.

---

## 📝 License
This project is licensed under the MIT License.

