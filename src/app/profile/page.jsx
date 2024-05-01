'use client'

import { useState, useEffect } from 'react'
import { useSession } from 'next-auth/react'
import { redirect, useRouter } from 'next/navigation'

import Profile from '@components/Profile'

const MyProfile = () => {
  const router = useRouter()
  const { data: session } = useSession()

  const [posts, setPosts] = useState([])

  useEffect(() => {
    const fetchPosts = async () => {
      const response = await fetch(`http://localhost/promptopia_php_mysql/users/details/?user_id=${session?.user.id}`)
      const data = await response.json()

      setPosts(data)
    }

    if (session?.user.id) {
      fetchPosts()
    }
  }, [session?.user.id])

  const handleEdit = (post) => {
    router.push(`/update-prompt?id=${post.prompt_id}`)
  }

  const handleDelete = async (post) => {
    const hasConfirmed = confirm('Are you sure you want to delete this prompt?')

    if (hasConfirmed) {
      try {
        await fetch(`http://localhost/promptopia_php_mysql/prompts/delete/?prompt_id=${post.prompt_id}`, {
          method: 'DELETE'
        })

        const filteredPosts = posts.filter((p) => p.prompt_id !== post.prompt_id)

        setPosts(filteredPosts)
      } catch (err) {
        console.log(err)
      }
    }
  }

  return (
    <div>
      <Profile name='My' desc='Welcome to your personalized profile page' data={posts} handleEdit={handleEdit} handleDelete={handleDelete} />
    </div>
  )
}

export default MyProfile