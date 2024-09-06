require('dotenv').config();
const express = require('express')
const app = express()
const port = process.env.APP_PORT || 3000

const hash = require('./hash')

app.use(express.json())

app.post('/', hash.hash)

app.listen(port, () => {
    console.log(`Example app listening on port ${port}`)
})
