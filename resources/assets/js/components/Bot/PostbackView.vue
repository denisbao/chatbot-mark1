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
    </div>
</template>

<script>
    import swal from 'sweetalert'

    export default {
        data: function () {
          return {
              showEditForm: false
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
                        this.$store.dispatch('addGetStarted', this.$route.params.id).then(() => {
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
                        this.$store.dispatch('removeGetStarted').then(() => {
                            swal("Concluído", "Botão começar não corresponde mais a este postback.", "success")
                        })
                    }
                });
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
    .swal-button {
        align-self: center;
    }
</style>

