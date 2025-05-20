import {useState} from 'react';

export default function AlunniRow(props){
    const a = props.alunni;
    const setAlunni=props.setAlunni;

    const [elimina, setElimina] = useState(false);

    async function eliminaAlunno(){
        setElimina(true)
        const data = await fetch(`http://localhost:8080/alunni/${a.id}`, { method:"DELETE" });
        const mieiDati = await data.json();

        setAlunni(prev => prev.filter(alunno => alunno.id !== a.id));
        setElimina(false);
    }
     
    return (
        <tr>
            <td>{a.id}</td>
            <td>{a.nome}</td>
            <td>{a.cognome}</td>
            <td>
                {elimina ? (
                    <div>
                        sei sicuro ?
                    <button onClick={() => eliminaAlunno()}>si</button>   
                    <button onClick={() => setElimina(false)}>no</button>                    
                    </div>
                ) : (
                    <button onClick={() => setElimina(true)}>elimina</button>
                )}
            </td>
        </tr>
    );
}