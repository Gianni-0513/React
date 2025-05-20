import './App.css';
import {useState} from 'react';
import AlunniTable from './AlunniTable';

function App() {

  const [alunni, setAlunni] = useState([]);

  const [load, setLoad] = useState(false);

  async function caricaAlunni(){
    setLoad(true);
    const data = await fetch("http://localhost:8080/alunni", { method:"GET" });
    const mieiDati = await data.json();
    setAlunni(mieiDati);
    setLoad(false);
  }

  return (
  <div className="App">
    {alunni.length > 0 ? (
      <AlunniTable myArray={alunni} setAlunni={setAlunni} />
    ):(
      <div>
        {load ? (
         <div>in Load</div>
        ) : (
        <button onClick={caricaAlunni}>carica alunni</button>
        )}
        </div>
    )}
    </div>
  );

}

export default App;