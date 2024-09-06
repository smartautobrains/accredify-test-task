const MerkleTools = require('merkle-tools')

const hash = (request, response) => {
    const array = request.body
    if (!array || !Array.isArray(array)) {
        return response.status(400).json({ error: 'Invalid array provided' })
    }
    const merkleTools = new MerkleTools()
    const json = JSON.stringify(array)
    const elementBuffer = Buffer.isBuffer(json) ? json : Buffer.from(json.toString())
    merkleTools.addLeaf(elementBuffer, true)
    merkleTools.makeTree()
    const merkleRoot = merkleTools.getMerkleRoot().toString('hex')
    response.json(merkleRoot)
}

module.exports = { hash }
