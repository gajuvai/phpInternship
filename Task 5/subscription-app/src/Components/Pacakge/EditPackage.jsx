import React, { useState, useEffect } from 'react';
import { Link, useParams, useNavigate } from 'react-router-dom';
import Navbar from '../Dashboard/Navbar';
// import axios from 'axios';

const EditPackage = () => {
    const { id } = useParams();
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [price, setPrice] = useState('');
    const [expires_date, setExpiresDate] = useState('');
    const [errorMessages, setErrorMessages] = useState([]);
    const navigate = useNavigate();
    const authToken = localStorage.getItem('authToken');
    // axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;

    if(!authToken){
        navigate('/');
    }

    useEffect(() => {
        // Fetch the package details based on the ID
        const fetchPackageDetails = async () => {
        
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/get-package/${id}`,{
                    method: 'GET',
                    headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                    },
                });
                const result = await response.json();

                if (result.status === 1) {
                    const packageData = result.package;
                    setTitle(packageData.title);
                    setDescription(packageData.description);
                    setPrice(packageData.price);
                    setExpiresDate(packageData.expires_date);
                } else {
                    setErrorMessages(result.message ? [result.message] : []);
                }
            } catch (error) {
                console.error('Error fetching package details:', error.message);
                setErrorMessages(['An error occurred while fetching package details.']);
            }
        };

        fetchPackageDetails();
    }, [id]);

    const handleEditPackage = async () => {
        const item = { title, description, price, expires_date };

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/update-package/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify(item),
            });

            const result = await response.json();

            if (result.status === 1) {
                console.log('Package edited successfully');
                navigate('/packagelist');
            } else {
                console.error('Error editing package:', result.message);
                setErrorMessages(result.message ? [result.message] : []);
            }
        } catch (error) {
            console.error('Error editing package:', error.message);
            setErrorMessages(['An error occurred while editing the package.']);
        }
    };
    const hasError = (fieldName) => errorMessages[fieldName] !== undefined;

    return (
        <div>
            <Navbar />

            <div className="container p-3">
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-body">
                            <h1>Edit Package</h1>
                            <br />

                            {/* {Object.keys(errorMessages).length > 0 && (
                            <div className="alert alert-danger">
                                <ul>
                                    {Object.values(errorMessages).map((error, index) => (
                                        <li key={index}>{error[0]}</li>
                                    ))}
                                </ul>
                            </div>
                        )} */}

                            <div className="mb-3">
                                <label htmlFor="title" className="form-label">Package Title</label>
                                <input type="text" className={`form-control ${hasError('title') ? 'is-invalid' : ''}`} id="title" value={title} onChange={(e) => setTitle(e.target.value)} />
                                {hasError('title') && (
                                    <div className="invalid-feedback">{errorMessages.title[0]}</div>
                                )}
                            </div>

                            <div className="mb-3">
                                <label htmlFor="description" className="form-label">Description</label>
                                <textarea className={`form-control ${hasError('description') ? 'is-invalid' : ''}`} id="description" value={description} onChange={(e) => setDescription(e.target.value)} />
                                {hasError('description') && (
                                    <div className="invalid-feedback">{errorMessages.description[0]}</div>
                                )}
                            </div>

                            <div className="mb-3">
                                <label htmlFor="price" className="form-label">Price</label>
                                <input type="number" className={`form-control ${hasError('price') ? 'is-invalid' : ''}`} id="price" value={price} onChange={(e) => setPrice(e.target.value)} />
                                {hasError('price') && (
                                    <div className="invalid-feedback">{errorMessages.price[0]}</div>
                                )}
                            </div>

                            <div className="mb-3">
                                <label htmlFor="expires_date" className="form-label">Expire Date</label>
                                <input type="date" className={`form-control ${hasError('expires_date') ? 'is-invalid' : ''}`} id="expires_date" value={expires_date} onChange={(e) => setExpiresDate(e.target.value)} />
                                {hasError('expires_date') && (
                                    <div className="invalid-feedback">{errorMessages.expires_date[0]}</div>
                                )}
                            </div>

                            <Link className='btn btn-danger' to={'/packagelist'}>Back</Link> &nbsp;
                            <button className='btn btn-primary' onClick={handleEditPackage}>Update Package</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default EditPackage;
