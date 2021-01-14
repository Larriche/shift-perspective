import './Results.css';

function ResultBreakdown(props) {
    const medianScore = 4;

    function getFullForm(char, dimension) {
        switch (dimension) {
            case 'EI':
                return char === 'E' ? 'Extraversion (E)' : 'Introversion (I)';
            case 'SN':
                return char === 'S' ? 'Sensing (S)' : 'Intuition (N)';
            case 'TF':
                return char === 'T' ? 'Thinking (T)' : 'Feeling (F)'
            case 'JP':
                return char === 'J' ? 'Judging (J)' : 'Perceiving (P)'

            default:
                return '';
        }
    }

    function getLeftBarClass() {
        return props.score <= medianScore ? 'Coloured' : 'Blank';
    }

    function getRightBarClass() {
        return props.score > medianScore ? 'Coloured' : 'Blank';
    }

    return (
        <tr>
            <td>{getFullForm(props.dimension[0], props.dimension)}</td>
            <td>
                <ul className="ResultBar">
                    <li className={getLeftBarClass()}></li>
                    <li className={getRightBarClass()}></li>
                </ul>
            </td>
            <td>{getFullForm(props.dimension[1], props.dimension)}</td>
        </tr>
    );
}

export default ResultBreakdown;