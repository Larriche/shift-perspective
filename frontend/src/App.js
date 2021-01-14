import React, { Component } from 'react';
import swal from '@sweetalert/with-react'
import QuestionsList from './components/questions/QuestionsList/QuestionsList';
import Results from './components/results/Results';

import './App.css';
class App extends Component {
  state = {
    questions: [],
    responses: {},
    email: '',
    results: null
  }

  constructor(props) {
    super(props)
    this.recordAnswer = this.recordAnswer.bind(this)
    this.emailChangeHandler = this.emailChangeHandler.bind(this)
    this.validateResponses = this.validateResponses.bind(this)
    this.submitForm = this.submitForm.bind(this)
    this.saveResponses = this.saveResponses.bind(this)
    this.displayErrorMessages = this.displayErrorMessages.bind(this);
  }

  /**
   * Validate form, confirm submission and submit form
   *
   * @return {Undefined}
   */
  submitForm() {
    let responsesValidated = this.validateResponses();

    if (responsesValidated) {
      if (this.state.email) {
        swal({
          title: "Confirm Form Submission",
          text: "Are you sure you want to submit your responses?",
          icon: "info",
          buttons: ['No', 'Yes'],
          dangerMode: false,
        })
        .then(response => {
          if (response) {
            this.saveResponses();
          }
        });
      } else {
        swal({
          title: "Please provide email",
          text: "Please enter your email",
          icon: "error",
          dangerMode: true,
        })
      }
    } else {
      swal({
        title: "Answer all questions",
        text: "Some questions have not been answered. Please check them",
        icon: "error",
        dangerMode: true,
      })
    }
  }

  /**
   * Make request to save responses and calculate MBTI
   *
   * @return {Undefined}
   */
  saveResponses() {
    let status = null;

    fetch('http://localhost:8000/api/mbti', {
      method: 'POST',
      body: JSON.stringify({
        responses: Object.values(this.state.responses),
        email: this.state.email
      }),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(res => {
      status = res.status;

      if (status !== 500) {
        return res.json();
      }
    })
    .then(res => {
      if (status === 201) {
        this.setState(state => {
          return {
            ...state,
            results: res
          }
        })
      } else if (status === 422) {
          this.displayErrorMessages(res.errors);
      } else {
        swal({
          title: "Unknown Error",
          text: "Your responses could not be saved",
          icon: "error",
          dangerMode: true,
        })
      }
    })
  }

  /**
   * Reload page for another response to be taken
   *
   * @return {Undefined}
   */
  refreshForm() {
    window.location.reload();
  }

  /**
   * Set the user's email in the state
   *
   * @param {Object} event
   */
  emailChangeHandler(event) {
    this.setState(state => {
      return {
        ...state,
        email: event.target.value
      }
    })
  }

  /**
   * Update a response selected by the user
   *
   * @param {Object} question Question response is selected for
   * @param {Integer} choice The selected choice
   */
  recordAnswer(question, choice) {
    this.setState(state => {
      let responses = state.responses;

      if (!responses[question.id]) {
        responses[question.id] = {
          question_id: question.id,
          dimension: question.dimension,
          direction: question.direction
        }
      }

      responses[question.id]['choice'] = choice;

      return {
        ...state,
        responses
      };
    })
  }

  /**
   * Check that each question has an associated answer in our set of responses
   *
   * @return {Boolean}
   */
  validateResponses() {
    for (let question of this.state.questions) {
      if (!this.state.responses[question.id]) {
        return false;
      }
    }

    return true;
  }

  /**
   * Display form validation errors gotten from the API
   *
   * @param {Object} errors Errors as gotten from the server
   * @return {Undefined}
   */
  displayErrorMessages(errors) {
    let errorsMessage = '';

    for (let errorGroup of Object.values(errors)) {
      for (let error of errorGroup) {
        errorsMessage += `${error}\n`;
      }
    }

    swal({
      title: "Errors",
      text: errorsMessage,
      icon: "error",
      dangerMode: true
    })
  }

  componentDidMount() {
    let status = null;

    fetch('http://localhost:8000/api/questions')
      .then(res => {
        status = res.status;

        if (status === 200) {
          return res.json();
        }
      })
      .then(data => {
        if (status === 200) {
          this.setState({ questions: data });
        } else {
          swal({
            title: "Unknown Error",
            text: "Loading questions failed",
            icon: "error",
            dangerMode: true,
          })
        }
      })
      .catch(error => console.log(error));
  }

  render() {
    return (
      !this.state.results ?
      (<section>
        <section id="heading">
          <h3>Discover Your Perspective</h3>
          <p>Complete the 7 min test and get a detailed report of your lenses on the world</p>
        </section>

        <QuestionsList questions={this.state.questions} onQuestionResponded={this.recordAnswer}></QuestionsList>

        <section id="email">
          <h3>Your Email</h3>
          <input type="text" placeholder="you@example.com" onChange={this.emailChangeHandler}></input>
        </section>

        <section className="ButtonDiv">
          <button onClick={this.submitForm}>Save and Continue</button>
        </section>
      </section>) : (
        <section>
          <Results results={this.state.results}></Results>

          <section className="ButtonDiv">
            <button onClick={this.refreshForm}>Fill in another response</button>
          </section>
        </section>
      )
    )
  }
}

export default App;
