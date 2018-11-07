<template>
    <div>
        <h3><small>Postback:</small> {{ postback.value }} </h3>

        <form @submit.prevent="save()" id="form-new-postback" v-if="showEditForm">
            <div class="input-field">
                <input id="value_to_postback" type="text" v-model="postback.value" required>
                <label for="value_to_postback" class="active">Identificação do postback</label>
                <input type="submit" value="Atualizar" class="btn">
            </div>
        </form>

        <p>
            <router-link :to="{path: '/'}" class="btn">Voltar</router-link>

            <a @click.prevent="addGetStartedButton()" href="" v-if="!postback.get_started" class="btn green">Ligar botão começar</a>
            <a @click.prevent="removeGetStartedButton()" href="" v-if="postback.get_started" class="btn green">Desligar botão começar</a>

            <a @click.prevent="showEditForm = !showEditForm" href="" class="btn blue">Editar</a>
            <a @click.prevent="remove()" href="" class="btn red">Remover</a>
        </p>

        <message v-for="message in postback.messages" :message-data="message"></message>

        <div class="card light-green">
            <div class="card-content">

                <form id="formNewMessage" @submit.prevent="newMessage()">
                    <h5>Nova Mensagem</h5>
                    <div class="input-filter">
                        <select class="browser-default" required v-model="dataToSave.type">
                            <option value="" disabled>Tipo da Mensagem</option>
                            <optgroup label="Mensagem">
                                <option value="text">Texto</option>
                                <option value="file">Arquivo</option>
                                <option value="audio">Audio</option>
                                <option value="image">Imagem</option>
                                <option value="video">Video</option>
                            </optgroup>
                            <optgroup label="Templates">
                                <option value="buttons">Botões</option>
                                <option value="generic">Slider</option>
                                <option value="generic">Lista</option>

                            </optgroup>
                        </select>
                    </div>
                    <div id="messageField" class="input-field">
                        <input type="text" required v-model="dataToSave.message">
                        <label>Mensagem</label>
                    </div>
                    <input id="messageSaveBtn" type="submit" value="+" class="btn green">
                </form>

            </div>
        </div>

    </div>
</template>

<script>
    import swal from 'sweetalert'
    import message from './Message';

    export default {
        components: {
            'message': message
        },
        data: function () {
          return {
              showEditForm: false,
              dataToSave: {
                  type: ''
              }
          }
        },
        methods: {
            save() {
                let data = {
                    id:  this.$route.params.id,
                    data: {
                        value: this.postback.value
                    }
                }
                this.$store.dispatch('updatePostback', data).then(() => {
                    swal('Salvo com sucesso!', 'O bot já deve responder a este postback', 'success')
                    this.showEditForm = false
                })
            },
            remove() {
                swal(
                    {
                        title: "Tem certeza?",
                        text: "Você não poderá desfazer esta ação.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        icon: "warning",
                        buttons: true,
                        buttons: [ "Cancelar", "Remover"],
//                        dangerMode: true,
                    }).then((confirmed) => {
                    if (confirmed) {
                        this.$store.dispatch('removePostback', this.$route.params.id).then(() => {
                            swal("Removido!", "Removido com sucesso.", "success")
                            this.$router.push("/")
                        })
                    }
                });
            },
            addGetStartedButton() {
                swal(
                    {
                        title: "Adicionar o botão começar?",
                        text: "Esse postback será definido como ação do botão iniciar.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
//                        closeOnConfirm: false,
//                        closeOnCancel: false,
                        icon: "warning",
                        buttons: true,
                        buttons: [ "Cancelar", "Definir"],
                    }).then((confirmed) => {
                    if (confirmed) {
                        this.$store.dispatch('addGetStarted', this.$route.params.id).then((res) => {
                            swal("Concluído", "Botão começar agora corresponde a este postback.", "success")
                            this.$store.dispatch('getPostback', this.$route.params.id)
                        })
                    }
                });
            },
            removeGetStartedButton() {
                swal(
                    {
                        title: "Desativar botão começar?",
                        text: "Esse postback deixará de ser a ação tomada com o botão iniciar.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        icon: "warning",
                        buttons: true,
                        buttons: [ "Cancelar", "Desativar"],
                    }).then((confirmed) => {
                    if (confirmed) {
                        this.$store.dispatch('removeGetStarted').then((res) => {
                            let err = res.data.error || null;
                            if (err) {
                                let message = 'Algo deu errado'
                                if (err.code === 100) {
                                    message = "Você precisa manter o botão começar. ele é necessário para a exibição do menu. Remova o menu primeiro."
                                }
                                swal ('Erro', message, 'error')
                            } else {
                                swal("Concluído", "Botão começar não corresponde mais a este postback.", "success")
                            }

                        })
                    }
                });
            },
            newMessage() {
                let $ = window.jQuery;
                $('#messageSaveBtn').val('Aguarde...').attr('disabled', true)

                let data = {
                    type: this.dataToSave.type || 'test',
                    message: this.dataToSave.message,
                    template: false,
                    postback_id: this.$route.params.id
                }

                let messageTypes = [
                    'text',
                    'file',
                    'audio',
                    'image',
                    'video',
                ];

                if (messageTypes.indexOf(data.type) === -1) {
                    data.template = true
                }

                this.$store.dispatch('newMessage', data).then(() => {
                    $('#messageSaveBtn').val('+').attr('disabled', false)
                    swal('Salvo com sucesso!','O bot já deverá responder com essa mensagem', 'success')
                    this.dataToSave = {type: 'text'}
                    this.$store.dispatch('getPostback', this.$route.params.id)
                })
            }
        },
        computed: {
            postback () {
                return this.$store.state.postback.postback
            }
        },
        mounted () {
            this.$store.dispatch('getPostback', this.$route.params.id)
        }
    }

</script>

<style>
    #messageField {
        background-color: rgba(255, 255, 255, 0.9);
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 2px;
    }
    #messageField input {
        margin-bottom: 0;
        border-bottom: none;
    }
    #messageField label {
        left: 10px;
    }
    #formNewMessage h5 {
        color: #fff;
    }
</style>

