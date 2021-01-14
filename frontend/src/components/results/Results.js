import ResultBreakdown from './ResultBreakdown';

function Results(props) {
    return (
        <div id="results">
            <div id="results-summary">
                <h3>Your Perspective</h3>
                <p>Your perspective type is {props.results.mbti.mbti}</p>
            </div>

            <div id="results-breakdown">
                <table>
                    <tbody>
                        {Object.keys(props.results.scores).map(dimension => (
                            <ResultBreakdown
                                score={props.results.scores[dimension]}
                                dimension={dimension}
                                key={dimension}></ResultBreakdown>
                        ))}
                    </tbody>
                </table>
            </div>

            <div className="clearfix"></div>
        </div>
    );
}

export default Results;