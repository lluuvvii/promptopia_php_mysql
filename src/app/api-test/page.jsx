'use client'
import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Install axios dengan npm install axios

const ApiTest = () => {
    const [users, setUsers] = useState([]);

    useEffect(() => {
        // Fungsi untuk mengambil data dari backend PHP
        const fetchData = async () => {
            try {
                const response = await axios.get('http://localhost/promptopia_php_mysql/prompt/');
                setUsers(response.data);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        };

        // Panggil fungsi fetchData saat komponen dimuat
        fetchData();
    }, []);

    return (
        <div>
            <h1>Data Pengguna</h1>
            <ul>
                {users?.map((user, i) => (
                    <li key={i}>{user.username}</li>
                ))}
            </ul>
        </div>
    );
};

export default ApiTest;
