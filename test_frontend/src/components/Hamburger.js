import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBars } from "@fortawesome/free-solid-svg-icons";
import "./Hamburger.css";

const Hamburger = ({ onClick }) => {
  return (
    <button className="hamburger" type="button" onClick={onClick}>
      <FontAwesomeIcon icon={faBars} />
    </button>
  );
};

export default Hamburger;
