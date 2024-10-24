(function () {
    class CheckoutFormHandler {
        constructor() {
            this.init();
        }

        init() {
            this.cacheElements();
            this.bindEvents();
            this.updatePrice();
            this.updateDependentsDisplay();
            // this.fillForm();
            window.callbackCep = this.callbackCep.bind(this); // Registra a função callbackCep no window
        }

        cacheElements() {
            this.form = document.getElementById('subscriptionForm');
            this.entity = document.getElementById('entity');
            this.messageContainer = document.getElementById('messageContainer');
            this.nameInput = document.getElementById('name');
            this.cpfCnpjInput = document.getElementById('cpfCnpj');
            this.emailInput = document.getElementById('email');
            this.noEmailCheckbox = document.getElementById('noEmail');
            this.phoneInput = document.getElementById('phone');
            this.postalCodeInput = document.getElementById('postalCode');
            this.addressInput = document.getElementById('address');
            this.addressNumberInput = document.getElementById('addressNumber');
            this.complementInput = document.getElementById('complement');
            this.provinceInput = document.getElementById('province');
            this.cityInput = document.getElementById('city');
            this.ufInput = document.getElementById('uf');
            this.numDependentsInput = document.getElementById('num_dependents');
            this.dependentsContainer = document.getElementById('dependents-container');
            this.subscriptionPrice = document.getElementById('subscription-price');
            this.holderNameInput = document.getElementById('holderName');
            this.cardNumberInput = document.getElementById('number');
            this.expiryMonthInput = document.getElementById('expiryMonth');
            this.expiryYearInput = document.getElementById('expiryYear');
            this.ccvInput = document.getElementById('ccv');
            this.addDependentButton = document.getElementById('add-dependent');
            this.removeDependentButton = document.getElementById('remove-dependent');
            this.numDependentsDisplay = document.getElementById('num-dependents');
            this.checkoutNonce = document.getElementById('checkout_nonce').value;
            this.submitButton = this.form.querySelector('[type=submit]');


            // Cache elements for the modal
            this.modalNameSpan = document.getElementById('contrato-nome');
            this.modalCpfCnpjSpan = document.getElementById('contrato-cpfcnpj');
            this.modalEnderecoSpan = document.getElementById('contrato-endereco');
            this.modalTriggerButton = document.querySelector('[data-bs-toggle="modal"]');
            this.acceptContent = document.getElementById('accept-content');
            this.acceptButton = document.querySelector('#modalAceitaTermos .btn-success');
        }

        bindEvents() {
            this.addDependentButton.addEventListener('click', this.addDependent.bind(this));
            this.removeDependentButton.addEventListener('click', this.removeDependent.bind(this));
            // this.noEmailCheckbox.addEventListener('change', this.toggleEmail.bind(this));
            this.phoneInput.addEventListener('input', this.applyPhoneMask.bind(this));
            // this.postalCodeInput.addEventListener('input', this.fetchAddress.bind(this));
            // this.postalCodeInput.addEventListener('blur', this.fetchAddress.bind(this));
            this.form.addEventListener('submit', this.handleSubmit.bind(this));

            this.nameInput.addEventListener('focusout', this.updateModalText.bind(this));
            this.cpfCnpjInput.addEventListener('focusout', this.updateModalText.bind(this));

            if (this.modalTriggerButton) {
                this.modalTriggerButton.addEventListener('click', this.updateModalText.bind(this));
            }

            this.acceptContent.addEventListener('scroll', this.checkScrollPosition.bind(this));
        }

        checkScrollPosition() {
            const contentHeight = this.acceptContent.scrollHeight;
            const scrollPosition = this.acceptContent.scrollTop + this.acceptContent.clientHeight + 1;

            if (scrollPosition >= contentHeight) {
                // this.acceptButton.disabled = false;
            }
        }

        updateModalText() {
            const nome = this.nameInput.value;
            const cpfCnpj = this.cpfCnpjInput.value;
            const endereco = this.addressInput.value;
            const numero = this.addressNumberInput.value;
            const complemento = this.complementInput.value ? ', ' + this.complementInput.value : '';
            const bairro = this.provinceInput.value;
            const cidade = this.cityInput.value;
            const uf = this.ufInput.value;
            const cep = this.postalCodeInput.value;

            const enderecoCompleto = `${endereco}, ${numero}${complemento}, ${bairro}, ${cidade} - ${uf}, CEP: ${cep}`;

            this.modalNameSpan.textContent = nome;
            this.modalCpfCnpjSpan.textContent = cpfCnpj;
            this.modalEnderecoSpan.textContent = enderecoCompleto;
        }

        addDependent() {
            const numDependents = parseInt(this.numDependentsInput.value) + 1;
            this.numDependentsInput.value = numDependents;
            this.createDependentField(numDependents - 1);
            this.updatePrice();
            this.updateDependentsDisplay();
            this.applyMasks();
        }

        removeDependent() {
            const numDependents = parseInt(this.numDependentsInput.value) - 1;
            if (numDependents >= 0) {
                this.numDependentsInput.value = numDependents;
                const lastDependent = document.getElementById(`dependent_${numDependents}`);
                if (lastDependent) {
                    lastDependent.remove();
                }
                this.updatePrice();
                this.updateDependentsDisplay();
            }
        }

        createDependentField(index) {
            const dependentHtml = `
                <div id="dependent_${index}" class="dependent mb-3">
                    <h4>Dependente ${index + 1}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="dependent_cpf_${index}" class="form-label">CPF:</label>
                            <input type="text" class="form-control bg-light border-0" id="dependent_cpf_${index}" name="dependent_cpf_${index}" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="dependent_name_${index}" class="form-label">Nome:</label>
                            <input type="text" class="form-control bg-light border-0" id="dependent_name_${index}" name="dependent_name_${index}" required />
                        </div>
                    </div>
                </div>
            `;
            this.dependentsContainer.insertAdjacentHTML('beforeend', dependentHtml);
        }

        updateDependentsDisplay() {
            const numDependents = parseInt(this.numDependentsInput.value);
            this.numDependentsDisplay.textContent = numDependents;
            this.removeDependentButton.disabled = numDependents === 0;
        }

        updatePrice() {
            const numDependents = parseInt(this.numDependentsInput.value);
            const data = {
                action: 'calculate_total_price',
                entity: this.entity.value,
                num_dependents: numDependents,
                lead_id: document.getElementById('lead_id') ? document.getElementById('lead_id').value : null
            };

            fetch(sysUrls.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.subscriptionPrice.innerText = 'R$ ' + (Math.ceil(data.data.total_price * 100) / 100).toFixed(2);
                        // this.subscriptionPrice.innerText = 'R$ ' + data.total_price;
                    } else {
                        this.showMessage('Erro ao calcular o preço: ' + data.data, 'danger');
                    }
                })
                .catch(err => {
                    this.showMessage('Erro ao calcular o preço: ' + err.message, 'danger');
                });
        }

        toggleEmail() {
            if (this.noEmailCheckbox.checked) {
                this.emailInput.disabled = true;

                // Remover caracteres especiais, deixando apenas números
                const cpfCnpjClean = this.cpfCnpjInput.value.replace(/[^0-9]/g, '');

                // const siteUrl = window.location.hostname;
                const siteUrl = 'dnacarebrasil.com.br';
                this.emailInput.value = `${cpfCnpjClean}@${siteUrl}`;
            } else {
                this.emailInput.disabled = false;
                this.emailInput.value = '';
            }
        }


        applyPhoneMask(e) {
            let x = e.target.value.replace(/\D/g, '');
            x = x.match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        }

        applyMasks() {
            const dependentCpfs = document.querySelectorAll('[id^="dependent_cpf_"]');
            dependentCpfs.forEach(input => input.addEventListener('input', this.applyCpfMask.bind(this)));
        }

        applyCpfMask(e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v;
        }

        fetchAddress(e) {
            let cep = e.target.value.replace(/\D/g, '');
            if (cep.length > 5) {
                cep = cep.substring(0, 5) + '-' + cep.substring(5, 8);
            }
            e.target.value = cep;
            if (cep.length === 9) {
                let cepSemMascara = cep.replace(/\D/g, '');
                let script = document.createElement('script');
                script.src = `https://viacep.com.br/ws/${cepSemMascara}/json/?callback=callbackCep`;
                document.body.appendChild(script);
            }
        }

        callbackCep(conteudo) {
            if (!("erro" in conteudo)) {
                this.addressInput.value = conteudo.logradouro;
                this.addressInput.disabled = false;
                this.provinceInput.value = conteudo.bairro;
                this.provinceInput.disabled = false;
                this.cityInput.value = conteudo.localidade;
                this.cityInput.disabled = false;
                this.ufInput.value = conteudo.uf;
                this.ufInput.disabled = false;
            } else {
                this.showMessage('CEP não encontrado.', 'danger');
            }
        }

        handleSubmit(event) {
            event.preventDefault();

            //para impedir reclique
            this.submitButton.disabled = true;

            const formData = new FormData(event.target);
            const payMethod = formData.get('pay-method');

            let formIsValid = true;
            const requiredFields = [
                this.nameInput,
                this.cpfCnpjInput,
                this.phoneInput,
                // this.emailInput,
                // this.postalCodeInput,
                // this.addressInput,
                // this.addressNumberInput,
                // this.provinceInput,
                // this.cityInput,
                // this.ufInput,
            ];

            // Campos obrigatórios apenas se o método de pagamento for cartão
            if (payMethod === 'CREDIT_CARD') {
                requiredFields.push(
                    this.holderNameInput,
                    this.cardNumberInput,
                    this.expiryMonthInput,
                    this.expiryYearInput,
                    this.ccvInput
                );
            }

            requiredFields.forEach((field) => {
                if (!field.value.trim()) {
                    formIsValid = false;
                    field.classList.add('is-invalid');  // Adiciona uma classe para destacar o campo inválido
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!formIsValid) {
                this.showMessage('Por favor, preencha todos os campos obrigatórios.', 'danger');
                this.closeModal();
                this.submitButton.disabled = false
                return;
            }

            // Desbloqueia campos antes do envio
            // if (this.noEmailCheckbox.checked) {
            //     this.emailInput.disabled = false;
            // }
            // this.addressInput.disabled = false;
            // this.provinceInput.disabled = false;
            // this.cityInput.disabled = false;
            // this.ufInput.disabled = false;

            // Converte o telefone para o formato sem máscara
            this.phoneInput.value = this.phoneInput.value.replace(/\D/g, '');

            // Validação antes de enviar o formulário
            if (!this.form.checkValidity()) {
                this.form.reportValidity();
                return;
            }


            const dependents = [];
            const numDependents = formData.get('num_dependents');
            for (let i = 0; i < numDependents; i++) {
                dependents.push({
                    cpf: formData.get(`dependent_cpf_${i}`),
                    name: formData.get(`dependent_name_${i}`)
                });
            }


            const data = {
                action: 'create_customer_and_subscription',
                lead_id: formData.get('lead_id'),
                entity: formData.get('entity'),
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                mobilePhone: formData.get('phone'),
                cpfCnpj: formData.get('cpfCnpj'),
                postalCode: formData.get('postalCode'),
                address: formData.get('address'),
                addressNumber: formData.get('addressNumber'),
                complement: formData.get('complement'),
                province: formData.get('province'),
                city: formData.get('city'),
                uf: formData.get('uf'),
                num_dependents: formData.get('num_dependents'),
                holderName: formData.get('holderName'),
                number: formData.get('number'),
                expiryMonth: formData.get('expiryMonth'),
                expiryYear: formData.get('expiryYear'),
                ccv: formData.get('ccv'),
                dependents: JSON.stringify(dependents),
                checkout_nonce: this.checkoutNonce,
                uuid: formData.get('uuid'),
                pay_method: payMethod
            };

            fetch(sysUrls.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.data;
                    } else {
                        this.showMessage('Erro ao criar assinatura: ' + data.data, 'danger');
                    }
                    this.submitButton.disabled = false;
                    this.closeModal();
                })
                .catch(err => {
                    this.showMessage('Erro ao criar assinatura: ' + err.message, 'danger');
                    this.submitButton.disabled = false;
                    this.closeModal();
                });

        }

        showMessage(message, type) {
            this.messageContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            this.messageContainer.scrollIntoView({ behavior: 'smooth' });
        }

        closeModal() {
            const modalElement = document.getElementById('modalAceitaTermos');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }

        fillForm() {
            this.nameInput.value = 'Adalberto';
            this.cpfCnpjInput.value = this.gerarCpf();
            this.postalCodeInput.value = '91310000';
            this.emailInput.value = this.getRandomEmail();
            this.phoneInput.value = this.getRandomPhoneNumber();
            this.addressInput.value = this.getRandomString(15);
            this.addressNumberInput.value = this.getRandomInt(1, 9999).toString();
            this.complementInput.value = this.getRandomString(5);
            this.provinceInput.value = this.getRandomString(10);
            this.holderNameInput.value = this.getRandomString(10);
            this.cardNumberInput.value = this.getRandomCreditCardNumber();
            this.expiryMonthInput.value = this.getRandomInt(1, 12).toString().padStart(2, '0');
            this.expiryYearInput.value = this.getRandomInt(2024, 2030).toString();
            this.ccvInput.value = this.getRandomInt(100, 999).toString();
        }

        gerarCpf() {
            function randomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }

            function calcularDigitoVerificador(digits) {
                let sum = 0;
                for (let i = 0; i < digits.length; i++) {
                    sum += digits[i] * ((digits.length + 1) - i);
                }
                const remainder = sum % 11;
                return remainder < 2 ? 0 : 11 - remainder;
            }

            const cpf = [];
            for (let i = 0; i < 9; i++) {
                cpf.push(randomInt(0, 9));
            }

            cpf.push(calcularDigitoVerificador(cpf));
            cpf.push(calcularDigitoVerificador(cpf));

            return cpf.join('');
        }

        getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        getRandomString(length) {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let result = '';
            for (let i = 0; i < length; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        getRandomEmail() {
            const domains = ['example.com', 'test.com', 'demo.com'];
            return this.getRandomString(5) + '@' + domains[Math.floor(Math.random() * domains.length)];
        }

        getRandomPhoneNumber() {
            return this.getRandomInt(1000000000, 9999999999).toString();
        }

        getRandomCreditCardNumber() {
            let number = '';
            for (let i = 0; i < 16; i++) {
                number += this.getRandomInt(0, 9).toString();
            }
            return number;
        }
    }

    window.CheckoutFormHandler = CheckoutFormHandler;
})();

document.addEventListener('DOMContentLoaded', function () {
    const subscriptionForm = document.getElementById('subscriptionForm');

    if (subscriptionForm) {
        new CheckoutFormHandler();
    } else {
        console.warn('Subscription form not found.');
    }
});
