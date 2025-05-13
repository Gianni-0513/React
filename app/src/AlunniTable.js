import AlunniRow from './AlunniRow';

export default function AlunniTable(props){
    const alunni = props.myArray;
    const setAlunni=props.setAlunni;

    return (
        <table border="1">
            {alunni.map(a =>
                <AlunniRow alunni={a} setAlunni={setAlunni}  />
            )}
        </table>
    )
}