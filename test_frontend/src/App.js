import React from "react";
import "./App.css";
import { BrowserRouter as Router, Route, Routes, Navigate } from "react-router-dom";
import Login from "./components/Login";
import Register from "./components/Register";
import Home from "./components/Home";

function App() {
  const token = localStorage.getItem("token") || null;
  return (
    <Router>
      <div className="App">
        <Routes>
          {!token && <Route path="/" element={<Navigate to="/login" />} />}
          {!token && <Route path="/login" element={<Login />} />}
          <Route path="/home" element={<Home />} />
          <Route path="/register" element={<Register />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;

