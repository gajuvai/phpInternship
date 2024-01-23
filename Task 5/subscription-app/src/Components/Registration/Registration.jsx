import React, { useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Registration = () => {
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [address, setAddress] = useState("");
    const [contact, setContact] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [errorMessages, setErrorMessages] = useState([]);

    const handleRegister = async () => {
        try {
            const response = await axios.post("http://127.0.0.1:8000/api/user/register", {
                name,
                email,
                address,
                contact,
                password,
                password_confirmation: passwordConfirmation
            });

            // Registration successful
            console.log(response.data);
        } catch (error) {
            // Handle validation errors or other errors
            if (error.response && error.response.data) {
                setErrorMessages(error.response.data.errors);
            } else {
                console.error("Error registering user:", error.message);
            }
        }
    };

    const hasError = (fieldName) => errorMessages[fieldName] !== undefined;

    return (
        <div className="container p-3">
            <div className="col-md-6 offset-md-3">
                <div className="card">
                    <div className="card-body">
                        <h1 className="card-title text-center">Registration Form</h1>
                        <br />

                        {/* Display validation errors */}
                        {Object.keys(errorMessages).length > 0 && (
                            <div className="alert alert-danger">
                                <ul>
                                    {Object.values(errorMessages).map((error, index) => (
                                        <li key={index}>{error[0]}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        <div className="mb-3">
                            <label htmlFor="name" className="form-label">Full Name</label>
                            <input type="text" className={`form-control ${hasError('name') ? 'is-invalid' : ''}`} id="name" value={name} onChange={(e) => setName(e.target.value)} />
                            {hasError('name') && (
                                <div className="invalid-feedback">{errorMessages.name[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="email" className="form-label">Email Address</label>
                            <input type="email" className={`form-control ${hasError('email') ? 'is-invalid' : ''}`} id="email" value={email} onChange={(e) => setEmail(e.target.value)} />
                            {hasError('email') && (
                                <div className="invalid-feedback">{errorMessages.email[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="address" className="form-label">Address</label>
                            <input type="text" className={`form-control ${hasError('address') ? 'is-invalid' : ''}`} id="address" value={address} onChange={(e) => setAddress(e.target.value)} />
                            {hasError('address') && (
                                <div className="invalid-feedback">{errorMessages.address[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="contact" className="form-label">Contact Number</label>
                            <input type="text" className={`form-control ${hasError('contact') ? 'is-invalid' : ''}`} id="contact" value={contact} onChange={(e) => setContact(e.target.value)} />
                            {hasError('contact') && (
                                <div className="invalid-feedback">{errorMessages.contact[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="password" className="form-label">Password</label>
                            <input type="password" className={`form-control ${hasError('password') ? 'is-invalid' : ''}`} id="password" value={password} onChange={(e) => setPassword(e.target.value)} />
                            {hasError('password') && (
                                <div className="invalid-feedback">{errorMessages.password[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="passwordConfirmation" className="form-label">Confirm Password</label>
                            <input type="password" className={`form-control ${hasError('password_confirmation') ? 'is-invalid' : ''}`} id="passwordConfirmation" value={passwordConfirmation} onChange={(e) => setPasswordConfirmation(e.target.value)} />
                            {hasError('password_confirmation') && (
                                <div className="invalid-feedback">{errorMessages.password_confirmation[0]}</div>
                            )}
                        </div>

                        <button className='btn btn-primary' onClick={handleRegister}>Register</button>
                        <br />
                        <br />
                        <p className="text-center">Already have an account? <Link to="/">Login here</Link>.</p>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Registration;
