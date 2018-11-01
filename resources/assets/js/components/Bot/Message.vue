<template>
    <div class="card">
        <span v-if="message.type === 'text'"class="teal lighten-2 white-text badge">{{ message.type }}</span>
        <span v-if="message.type === 'audio'"class="blue lighten-1 white-text badge">{{ message.type }}</span>
        <span v-if="message.type === 'image'"class="orange lighten-1 white-text badge">{{ message.type }}</span>
        <span v-if="message.type === 'file'"class="deep-purple lighten-2 white-text badge">{{ message.type }}</span>
        <span v-if="message.type === 'video'" class="red lighten-2 white-text badge">{{ message.type }}</span>

        <div class="card-content">
            <blockquote>
                <stron>Mensagem:</stron> {{ message.message }}
            </blockquote>

            <img :src="message.message" v-if="message.type === 'image'" class="responsive-img">

            <audio controls v-if="message.type === 'audio'">
                <source :src="message.message">
            </audio>

            <div v-if="message.type === 'video'" class="video-container">
                <video controls style="max-width: 100%">
                    <source :src="message.message">
                </video>
            </div>

            <blockquote v-if="message.type === 'file'">
                <a :href="message.message"><i class="material-icons">attach_file</i> Arquivo para download</a>
            </blockquote>

            <form @submit.prevent="update(currentMessage)" v-if="showEditForm">
                <div class="input-field">
                    <input type="text" class="form-control" placeholder="Mensagem ou URL..." v-model="currentMessage" required>
                    <label class="active">Mensagem</label>
                </div>
                <input id="messageSaveBtn" type="submit" value="atualizar" class="btn">
                <input type="button" value="cancelar" class="btn lime" @click.prevent="showEditForm = !showEditForm">
                <hr>
            </form>


        </div>

        <div class="card-action">
            <a href="" @click.prevent="showEditForm = !showEditForm; currentMessage = message.message">Editar</a>
            <a href="" @click.prevent="remove()">Remover</a>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'messageData'
        ],
        data: function () {
            return {
                currentMessage: null,
                showEditForm: false
            }
        },
        methods: {
          update: function (message) {
              let data = {
                  id: this.message.id,
                  data: {
                      type: this.message.type,
                      message: message
                  }
              }

              this.$store.dispatch('updateMessage', data).then(() => {
                 swal ('Salvo com sucesso', 'O bot já está respondendo com essa atualização', 'success')
                 this.message.message = message
                 this.showEditForm = false;
                 this.$store.dispatch('getPostback', this.$route.params.id)
              });
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
                    }).then((confirmed) => {
                    if (confirmed) {
                        this.$store.dispatch('removeMessage', this.message.id).then(() => {
                            swal("Removido!", "Removido com sucesso.", "success")
                            this.$store.dispatch('getPostback', this.$route.params.id)
                        })
                    }
                });
            },
        },
        computed: {
            message: function () {
                return this.messageData
            }
        }
    }
</script>