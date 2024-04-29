'use client'
import React, { useState, useEffect } from 'react'
import axios from 'axios'; // Install axios dengan npm install axios
import Image from 'next/image';

const ApiTest = () => {
  const [users, setUsers] = useState([])
  const [prompts, setPrompts] = useState([])

  useEffect(() => {
    // Fungsi untuk mengambil data dari backend PHP
    const fetchData = async () => {
      try {
        const response = await axios.get('http://localhost/promptopia_php_mysql/users/')
        setUsers(response.data)
      } catch (error) {
        console.error('Error fetching data:', error)
      }
    }

    const getPrompts = async () => {
      try {
        const response = await axios.get('http://localhost/promptopia_php_mysql/prompts/')
        setPrompts(response.data)
      } catch (error) {
        console.error('Error fetching data:', error)
      }
    }

    // Panggil fungsi fetchData saat komponen dimuat
    fetchData()
    getPrompts()
  }, [])

  return (
    <div>
      <h1>Data Pengguna</h1>
      <ul>
        {users?.map((user, i) => (
          <li key={i}>{user.username}</li>
        ))}
      </ul>
      <ul>
        {prompts?.map((prompt, i) => (
          <div key={i}>
            <li>Email : {prompt.email}</li>
            <li>Username : {prompt.username}</li>
            <li>Image : <Image src={prompt.image} alt={prompt.username} width={40} height={40} className='rounded-full object-contain' /></li>
            <li>Prompt : {prompt.prompt}</li>
            <li>Tag : {prompt.tag}</li>
          </div>
        ))}
      </ul>
    </div>
  )
}

export default ApiTest
