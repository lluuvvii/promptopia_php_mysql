import NextAuth from 'next-auth';
import GoogleProvider from 'next-auth/providers/google'

import User from '@models/user';
import { connectDb } from '@utils/database'
import axios from 'axios';

const handler = NextAuth({
  providers: [
    GoogleProvider({
      clientId: process.env.GOOGLE_ID,
      clientSecret: process.env.GOOGLE_CLIENT_SECRET,
      authorization: 'https://accounts.google.com/o/oauth2/auth?prompt=select_account'
    })
  ],
  callbacks: {
    async session({ session }) {
      // const sessionUser = await User.findOne({ email: session.user.email })
      const response = await axios.get('http://localhost/promptopia_php_mysql/users/');

      const userSql = response.data.filter((obj) => obj.email === session.user.email).map(obj => obj.user_id)

      // console.log({user_id: userSql[0].toString()})

      session.user.id = userSql[0].toString()

      return session
    },
    async signIn({ profile }) {
      try {
        // await connectDb()

        // check if user already exists
        // const userExists = await User.findOne({ email: profile.email })

        // check if not, create a new user
        // if (!userExists) {
        //   await User.create({
        //     email: profile.email,
        //     username: profile.name.replace(" ", "").toLowerCase(),
        //     image: profile.picture
        //   })
        // }

        const response = await axios.get('http://localhost/promptopia_php_mysql/users/');

        const userSql = response.data.filter((obj) => obj.email === profile.email).map(obj => obj.email)

        const userData = {
          email: profile.email,
          username: profile.name.replace(" ", "").toLowerCase(),
          image: profile.picture
        }
        if (!userSql[0]) {
          const addUser = async () => {
            const responsePost = await fetch('http://localhost/promptopia_php_mysql/users/create/',
              {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
              })

            console.log({ userData })
            console.log(responsePost.json())
          }

          addUser()
          return true
        }

        return true
      } catch (err) {
        console.log(err)
        return false
      }
    }
  }
})

export { handler as GET, handler as POST }