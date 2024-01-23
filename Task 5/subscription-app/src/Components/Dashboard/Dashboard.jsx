import React from 'react';
import {useNavigate } from 'react-router-dom';
import Navbar from './Navbar';
// import axios from 'axios';

// axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;

const Dashboard = () => {

    const navigate = useNavigate();
    const authToken = localStorage.getItem('authToken');


    if(!authToken){
        navigate('/');
    }

    return (
        <div>
            <Navbar/>

            {/* Main Content */}
            <div className="container p-3">
                <div className="col-md-6 offset-md-3">
                    <div className="card">
                        <div className="card-body">
                            <h1 className="card-title text-center">Dashboard</h1>
                            <p className="text-center">Welcome to the Dashboard!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Dashboard;
