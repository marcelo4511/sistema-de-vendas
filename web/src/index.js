import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from '../src/components/main/App';
import 'bootstrap/dist/css/bootstrap.min.css'; 
import store from './store/index'
import {Provider} from 'react-redux'


ReactDOM.render(
  <React.StrictMode>
    <Provider store={store}>
    <App />

    </Provider>
  </React.StrictMode>,
  document.getElementById('root')
);

// u