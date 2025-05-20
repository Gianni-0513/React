import {use, useState} from 'react';

export default function AlunniRow(props){
    const a = props.alunni;
    const setAlunni=props.setAlunni;

    const [elimina, setElimina] = useState(false);

    const [edit, setEdit] = useState(false);

    const [nome, setNome] = useState(a.nome);
    const [cognome, setCognome] = useState(a.cognome);

    const [load, setLoad] = useState(false);

    async function eliminaAlunno(){
        setElimina(true)
        const data = await fetch(`http://localhost:8080/alunni/${a.id}`, { method:"DELETE" });
        const mieiDati = await data.json();

        setAlunni(prev => prev.filter(alunno => alunno.id !== a.id));
        setElimina(false);


    }

    async function caricaAlunni(){
        setLoad(true);
        const data = await fetch("http://localhost:8080/alunni", { method:"GET" });
        const mieiDati = await data.json();
        setAlunni(mieiDati);
        setLoad(false);
      }

    async function editAlunno(){
        const data = await fetch(`http://localhost:8080/alunni/${a.id}`, { 
            method:"PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({nome, cognome})
        });
        setEdit(false);
        caricaAlunni();
    }

    return (
        <tr>
            <td>{a.id}</td>

            <td>
            {edit ? (
                <input type='text' value={nome} onChange={(e) => setNome(e.target.value)} />
            ):(a.nome)}
            </td>

            <td>
            {edit ? (
                <input type='text' value={cognome} onChange={(e) => setCognome(e.target.value)} />
            ):(a.cognome)}
            </td>

            <td>
                {elimina ? (
                    <div>
                    <button onClick={() => eliminaAlunno()}>si</button>   
                    <button onClick={() => setElimina(false)}>no</button>                    
                    </div>
                ) : (
                    <button onClick={() => setElimina(true)}>elimina</button>
                )}
                <button  onClick={() => edit ? editAlunno() : setEdit(true)}>edit</button>
            </td>
        </tr>
    );
}