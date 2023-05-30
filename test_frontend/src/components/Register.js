import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Navbar from "./Navbar";
import Hamburger from "./Hamburger";
import Footers from "./Footers";
import "./Style.css";

const Register = () => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");
  const navigate = useNavigate();
  const [showMenu, setShowMenu] = useState(false);

  const toggleMenu = () => {
      setShowMenu(!showMenu);
  };

  const handleSubmit = async (e) => {
      e.preventDefault();

      try {
          const response = await axios.post("http://127.0.0.1:8000/api/register", {
              name,
              email,
              password,
              password_confirmation: passwordConfirmation,
          });
          navigate("/");
      } catch (err) {
          console.log("Register Error", err);
      }
  };
  return (
    <>
    <div className="style">
      <Navbar />
      <Hamburger onClick={toggleMenu} />
      <div className="forms">
        <img className="icon" src="https://muhamadrifqi.com/img/_logo_Image.png" alt="Logo" />
        <h1>Register</h1>
        <form onSubmit={handleSubmit}>
          <div className="input-group">
            <label htmlFor="name">Name:</label>
              <input
                type="text"
                id="name"
                value={name}
                onChange={(e) => setName(e.target.value)}
              />
          </div>
          
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
          
          <div className="input-group">
            <label htmlFor="password_confirmation">Confirm Password:</label>
              <input
                type="password"
                id="password_confirmation"
                value={passwordConfirmation}
                onChange={(e) => setPasswordConfirmation(e.target.value)}
              />
          </div>
          <button type="submit">Register</button>
        </form>
      </div>
    </div>
    <Footers />
    </>
    );

};

export default Register;