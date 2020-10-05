import React, { useState } from 'react'
import {View,Text,TextInput,Button, Picker} from 'react-native'
import axios from 'axios'
//import {Button} from 'react-native-paper'
//port {withFormik} from 'formik'

function Categories() {

  const [name,setName] = useState('')
  const [status,setStatus] = useState('')

   function onSubmit(){
          axios.post('http://127.0.0.1:8000/api/categories',{
          name,
          status
        }).then(res => {
          console.log(res.data)
          alert("sucesso")
        })
  }
 
  return (
    <View style={{display:'flex',justifyContent:'center',alignItens:'center',margin:40}}>
        
        

        <Text style={{color:'blue'}}>Cadastro de Categorias</Text>
       

        

        <TextInput style={{borderWidth:2,borderColor:'black',marginTop:20}}
        label="Nome"
        value={name}
        placeholder='nome'
        onChange={e => setName(e.target.value)}
        />

        <Picker style={{borderWidth:2,borderColor:'blck',marginTop:20}}
        onValueChange={(itemValue, itemIndex) => setStatus(itemValue)}
        >
          <option value=""></option>
        <Picker.Item label="Ativo" value="Ativo" />
        <Picker.Item label="Inativo" value="Inativo" />
      </Picker>

         <Button tyle={{marginTop:20}}
          title="salvar"
           onPress={onSubmit}/>
      </View>
    );
  }

  
  export default Categories