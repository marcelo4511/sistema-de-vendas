import React from 'react'
import {View,Text,StyleSheet} from 'react-native'

function Home() {
    return (
      <View style={styles.container}>
        <Text
          style={styles.text}
        >Sistema de vendas</Text>
      </View>
    );
  }
  const styles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: 'blue',
      alignItems: 'center',
      justifyContent: 'center',
     
    },
    text:{
      
      color:'#fff',
      width:200,
      height:50,
      fontWeight: 'bold',
      fontSize: 20,
      alignItems:"center",
      justifyContent:"center",
    },
  });
  export default Home