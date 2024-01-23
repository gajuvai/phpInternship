import React from 'react';
import { Link } from 'react-router-dom';

const Navbar = () => {
  return (
    <div className="container">
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
            <div className="container-fluid">
                <Link to="/dashboard" className="navbar-brand">Package Management</Link>
                <div className="collapse navbar-collapse">
                    <ul className="navbar-nav me-auto">
                        <li className="nav-item">
                        <Link to="/dashboard" className="nav-link">Dashboard</Link>
                        </li>
                        <li className="nav-item">
                        <Link to="/packagelist" className="nav-link">Packages</Link>
                        </li>
                    </ul>
                </div>
                <Link to="/logout" className="btn btn-danger">Logout</Link>
            </div>
        </nav>
    </div>
    
  );
};

export default Navbar;
