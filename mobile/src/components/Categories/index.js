import React, { useState } from 'react'
import {View,Text,StyleSheet} from 'react-native'
import {Button, TextInput} from 'react-native-paper'
//port {withFormik} from 'formik'

function Categories() {

  const [name,useName] = useState('')
  const [status,useStatus] = useState('')
  
  return (
    <View styles={styles.container}>
        
        <View styles={styles.topo}>

        <Text styles={styles.text}>Cadastro de Categorias</Text>
        </View>

        <View styles={styles.aaa}>

        <TextInput styles={styles.teste}
        label="Nome"
        value={name}/>
        </View>

        <TextInput
        label="Status"
        value={status}
        />
         <Button 
         icon="check"
         mode="contained"
         onPress={() => console.log('Pressed')}>
         Cadastrar
        </Button>
      </View>
    );
  }

  const styles = StyleSheet.create({
    container:{
      justifyContent: 'center',
      alignItems:"center",
      display:'flex',
    },

    teste:{
      width:100,
    },

    topo:{
      marginTop:200,
    },

    aaa:{
      marginTop:400,
    },

    text:{
      fontSize:200,
    },
  })

  export default Categories