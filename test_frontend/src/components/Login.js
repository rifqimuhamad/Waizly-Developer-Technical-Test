import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Navbar from "./Navbar";
import Hamburger from "./Hamburger";
import Footers from "./Footers";
import "./Style.css";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();
  const [showMenu, setShowMenu] = useState(false);

  const toggleMenu = () => {
      setShowMenu(!showMenu);
  };

  const token = localStorage.getItem("token");

  useEffect(() => {
    if (token) {
      navigate("/home"); 
    }
  }, []);

  const handleSubmit = async (e) => {
      e.preventDefault();
      try {
          const response = await axios.post("http://127.0.0.1:8000/api/login", {
              email,
              password,
          });

          const token = response.data.access_token;
          localStorage.setItem('token', token);
          navigate("/home");

      } catch (err) {
          alert('Login Error')
          console.log("Login Error", err);
      }
  };

  return (
    <>
      <div className="style">
        <Navbar />
        <Hamburger onClick={toggleMenu} />
        <div className="forms">
          <img className="icon" src="https://muhamadrifqi.com/img/_logo_Image.png" alt="Logo" />
          <h1>Login</h1>
          <form onSubmit={handleSubmit}>
            <div className="input-group">
              <label htmlFor="email">Email:</label>
              <input
                type="email"
                id="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="input-group">
              <label htmlFor="password">Password:</label>
              <input
                type="password"
                id="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <button type="submit">Login</button>
          </form>
        </div>
      </div>
      <Footers />
    </>
  );
};

export default Login;
