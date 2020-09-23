

export default{
    state:{
        isMenuVisible:true
    },
    
    mutations: {
        toggleMenu(state,isVisible) {
            if(isVisible == undefined) {
                state.isMenuVisible = !state.isMenuVisible
            } else {
                state.isMenuVisible = isVisible
            }

            console.log('toggleMenu = ' + state.isMenuVisible)
        }
    }
}