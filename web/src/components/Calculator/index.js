import React from 'react'
import { useSelector} from 'react-redux'

function Calculator(){
    
    const result = useSelector(function (state){
        return state.calculator
    })
    return (
        <div>

        <input type="text" placeholder="a"/>
        <input type="text" placeholder="b"/>

        <button>Somar</button>
        <button>subtrair</button>

    <p>{result}</p>
        </div>
    )
}



export default Calculator