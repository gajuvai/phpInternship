import React, { useState, useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import Navbar from '../Dashboard/Navbar';

// let i = 0;
// const authToken = localStorage.getItem('authToken');

const PackageList = () => {

    const navigate = useNavigate();
    const authToken = localStorage.getItem('authToken');
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;

    if(!authToken){
        navigate('/');
    }

    const [packages, setPackages] = useState([]);

    useEffect(() => {
        // Fetch all packages from the API
        
        const fetchPackages = async () => {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/get-packages");
                setPackages(response.data.packages);
            } catch (error) {
                console.error("Error fetching packages:", error.message);
            }
        };

        fetchPackages();
    }, []);

    const handleDelete = async (id) => {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/delete-package/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
          });
    
          const result = await response.json();
    
          if (result.status === 1) {

            console.log('Package deleted successfully');
            window.location.reload();

          } else {
            // Handle error (e.g., show error message)
            console.error('Error deleting package:', result.message);
          }
        } catch (error) {
          console.error('Error deleting package:', error.message);
        }
      };

    return (
        <div>
            <Navbar/>
            {/* Main Content */}
            <div className="container p-3">
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-body">
                            <h2 className="mb-4">All Packages</h2>
                            <Link className='btn btn-primary' to={'/addpackage'}>Add Package</Link> <br/>
                            <table className="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Package Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {packages.map((packageItem) => (
                                        
                                        <tr key={packageItem.id}>
                                            <td>#</td>
                                            <td>{packageItem.title}</td>
                                            <td>{packageItem.description}</td>
                                            <td>Rs. {packageItem.price}</td>
                                            <td>
                                                <Link to={`/editpackage/${packageItem.id}`} className="btn btn-primary me-2">Edit</Link>
                                                <button onClick={() => handleDelete(packageItem.id)} className="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    );
};

export default PackageList;
