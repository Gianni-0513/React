import './App.css';
import {useState} from 'react';
import AlunniTable from './AlunniTable';

function App() {

  const [alunni, setAlunni] = useState([]);

  const [load, setLoad] = useState(false);

  const [inserisci, setInserisci] = useState(false);

  const [nome, setNome] = useState("");
  const [cognome, setCognome] = useState("");

  const [nomeErr, setNomeErr] = useState("");
  const [cognomeErr, setCognomeErr] = useState("");


  async function caricaAlunni(){
    setLoad(true);
    const data = await fetch("http://localhost:8080/alunni", { method:"GET" });
    const mieiDati = await data.json();
    setAlunni(mieiDati);
    setLoad(false);
  }

  async function salvaAlunno(){
    if(nome === "") {
      setNomeErr("Nome obbligatorio");
      return
    }

    if(cognome === "") {
      setCognomeErr("Cognome obbligatorio");
      return
    }

    const data = await fetch("http://localhost:8080/alunni", { 
      method:"POST", 
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({nome: nome, cognome: cognome})
    });
    setNome("");
    setCognome("");
    setNomeErr("");
    setCognomeErr("");
    caricaAlunni();
  }


  return (
  <div className="App">
    {alunni.length > 0 ? (
      <div>
      <AlunniTable myArray={alunni} setAlunni={setAlunni} />
      {inserisci ? (
        <div>

          <h5>Nome</h5>
          <input onChange={(e)=>setNome(e.target.value)} type='text'></input>
          { nomeErr !== "" && <div>{nomeErr}</div> } 

          <h5>Cognome</h5>
          <input onChange={(e)=>setCognome(e.target.value)} type='text'></input>
          { cognomeErr !== "" && <div>{cognomeErr}</div> } 

          <br />
          <button onClick={salvaAlunno}>Salva</button>
          <br />
          <button onClick={() => setInserisci(false)}>Anulla</button>
        </div>
      ):(
        <button onClick={() => setInserisci(true)}>inserisci nuovo alunno</button>
      )}
      </div>
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