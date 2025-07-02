/**
 *  Pages Authentication
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          username: {
            validators: {
              notEmpty: {
                message: "Veuillez entrer un nom d'utilisateur"
              },
              stringLength: {
                min: 6,
                message: "Le nom d'utilisateur doit contenir plus de 6 caractères"
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Veuillez entrer votre email'
              },
              emailAddress: {
                message: 'Veuillez entrer une adresse email valide'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: "Veuillez entrer un email ou un nom d'utilisateur"
              },
              stringLength: {
                min: 6,
                message: "Le nom d'utilisateur doit contenir plus de 6 caractères"
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Veuillez entrer votre mot de passe'
              },
              stringLength: {
                min: 6,
                message: 'Le mot de passe doit contenir plus de 6 caractères'
              }
            }
          },
          'confirm-password': {
            validators: {
              notEmpty: {
                message: 'Veuillez confirmer le mot de passe'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Le mot de passe et sa confirmation ne correspondent pas'
              },
              stringLength: {
                min: 6,
                message: 'Le mot de passe doit contenir plus de 6 caractères'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: "Veuillez accepter les conditions d'utilisation"
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-6'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }

    // Two Steps Verification
    const numeralMask = document.querySelectorAll('.numeral-mask');

    // Verification masking
    if (numeralMask.length) {
      numeralMask.forEach(e => {
        new Cleave(e, {
          numeral: true
        });
      });
    }
  })();
});
