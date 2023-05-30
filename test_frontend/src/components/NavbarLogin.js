import React from "react";
import "./Navbar.css";
import { useNavigate } from "react-router-dom";

const NavbarLogin = () => {
  const navigate = useNavigate();

  const handleLogout = () => {
    localStorage.removeItem("token");
    navigate("/login");
  };

  return (
    <nav>
      <img src="https://muhamadrifqi.com/img/_logo_Image.png" className="logo" alt="logo" />
      <ul>
        <li>
          <a href="/" onClick={handleLogout}>LOGOUT</a>
        </li>

      </ul>
    </nav>
  );
};

export default NavbarLogin;
