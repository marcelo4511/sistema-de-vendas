import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { Button, StyleSheet, Text, View } from 'react-native';

export default function App() {
  return (
    <View style={styles.container}>
      <Text style={styles.text}>vamos começcar um sistema de vendas !!!</Text>
      <Button style={styles.button} title="iniciar"/>
      <StatusBar style="auto" />
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
    width:100,
  },
  button:{
    backgroundColor:'violet',
    color:'#fff'
  }
});
