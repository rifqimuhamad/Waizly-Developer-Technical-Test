import React from "react";
import "./Navbar.css";


const Navbar = () => {
  return (
    <nav>
      <img src="https://muhamadrifqi.com/img/_logo_Image.png" className="logo" alt="logo" />
      <ul>
        <li>
          <a href="/login">LOGIN</a>
        </li>
        <li>
          <a href="/register">REGISTER</a>
        </li>

      </ul>
    </nav>
  );
};

export default Navbar;
