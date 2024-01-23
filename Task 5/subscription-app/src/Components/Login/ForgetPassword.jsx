import React, { useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const ForgetPassword = () => {
    const [email, setEmail] = useState("");
    const [newPassword, setNewPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [errorMessages, setErrorMessages] = useState([]);
    const [successMessage, setSuccessMessage] = useState("");

    const handleForgetPassword = async () => {
        try {
            const response = await axios.post("http://your-laravel-api-url/api/user/forget-password/1", {
                email,
                new_password: newPassword,
                confirm_password: confirmPassword,
            });

            // Password reset successful
            setSuccessMessage(response.data.message);
            setErrorMessages([]);

        } catch (error) {
            // Handle validation errors or other errors
            if (error.response && error.response.data) {
                setErrorMessages([error.response.data.message]);
            } else {
                console.error("Error resetting password:", error.message);
            }
        }
    };

    const hasError = (fieldName) => errorMessages[fieldName] !== undefined;

    return (
        <div className="container p-3">
            <div className="col-md-6 offset-md-3">
                <div className="card">
                    <div className="card-body">
                        <h1 className="card-title text-center">Forget Password</h1>
                        <br />

                        {/* Display validation errors */}
                        {errorMessages.length > 0 && (
                            <div className="alert alert-danger">
                                <ul>
                                    {errorMessages.map((error, index) => (
                                        <li key={index}>{error}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        {/* Display success message */}
                        {successMessage && (
                            <div className="alert alert-success">{successMessage}</div>
                        )}

                        <div className="mb-3">
                            <label htmlFor="email" className="form-label">Email Address</label>
                            <input type="email" className={`form-control ${hasError('email') ? 'is-invalid' : ''}`} id="email" value={email} onChange={(e) => setEmail(e.target.value)} />
                            {hasError('email') && (
                                <div className="invalid-feedback">{errorMessages[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="newPassword" className="form-label">New Password</label>
                            <input type="password" className={`form-control ${hasError('new_password') ? 'is-invalid' : ''}`} id="newPassword" value={newPassword} onChange={(e) => setNewPassword(e.target.value)} />
                            {hasError('new_password') && (
                                <div className="invalid-feedback">{errorMessages[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="confirmPassword" className="form-label">Confirm Password</label>
                            <input type="password" className={`form-control ${hasError('confirm_password') ? 'is-invalid' : ''}`} id="confirmPassword" value={confirmPassword} onChange={(e) => setConfirmPassword(e.target.value)} />
                            {hasError('confirm_password') && (
                                <div className="invalid-feedback">{errorMessages[0]}</div>
                            )}
                        </div>

                        <button className='btn btn-primary' onClick={handleForgetPassword}>Reset Password</button>
                        <br />
                        <br />
                        <p className="text-center">
                            Remember your password? <Link to="/">Login here</Link>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ForgetPassword;
