const listando = (state) => state.list.forEach(i => {
    return i
})

const totalCategory = (state) => state.list.length

const listar = (state) => state.list.find(l => l.id == l.id)

const buscar = (state) => state.list.filter(busca => busca.status == 'Ativo')
export default{
    listando,
    totalCategory,
    buscar,
    listar,
}