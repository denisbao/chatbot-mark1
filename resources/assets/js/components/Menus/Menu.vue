<template>
    <div>
        <h3>Menus do Bot</h3>
        <button class="btn red" @click.prevent="removeMenu()" style="margin-bottom: 20px;">Limpar menu do Bot</button>

        <div v-if="menus.data.length > 0" class="row" style="margin-bottom: 20px;">
            <router-link
            v-for="menu in menus.data"
            class="col s12 waves-effect waves-light btn-large light-green" style="margin-bottom: 20px;"
            :to="{path: 'menu/' + menu.id}">
                {{ menu.locale }} <small>Campo de mensagem: {{ menu.composer_input_disabled ? 'desativado' : 'ativado' }}</small>

            </router-link>
        </div>

        <div class="card red" v-if="menus.data.length === 0">
            <div class="card-content white-text">
                Nenhum menu cadastrado...
            </div>
        </div>

        <form @submit.prevent="save()">
            <legend>Novo Menu</legend>
            <div class="row">
                <div class="input-group col s6">
                    <input type="text" placeholder="Locale" v-model="locale" required>
                </div>
                <div class="input-group col s6">
                    <p>
                        <a href="https://developers.facebook.com/docs/messenger-platform/messager-profile/supported-locales" target="_blank">Locales suportados</a>
                    </p>
                </div>
                <div class="input-group margin-botton col s12" style="margin-bottom: 20px; margin-top: 20px;">
                    <!--<input id="composer_input_disabled" type="checkbox" v-model="composer_input_disabled" checked="checked">-->
                    <!--<label for="composer_input_disabled">Exibir compo de mensagem?</label>-->
                    <label>
                        <input id="composer_input_disabled" class="filled-in" type="checkbox" v-model="composer_input_disabled" checked="checked">
                        <span>Desabilitar campo de mensagem</span>
                    </label>
                </div>
                <div class="input-group col s12">
                    <input type="submit" value="+" class="btn" >
                </div>
            </div>
        </form>

    </div>
</template>

<script>
    import swal from 'sweetalert'

    export default {
        data: function () {
            return {
                locale: 'default',
                composer_input_disabled: false // ATIVA - DESATIVA ENTRADA DE TEXTO NO CHAT
            }
        },
        methods: {
            save: function () {
                let data = {
                    locale: this.locale,
                    composer_input_disabled: this.composer_input_disabled
                }
                this.$store.dispatch('newMenu', data).then(() => {
                    this.$store.dispatch('getMenus')
                    this.locale = 'default'
                    this.composer_input_disabled = true
                })
            },
            removeMenu: function () {
                swal(
                    {
                        title: "Tem certeza?",
                        text: "Você irá remover os menus no Facebook. Para desfazer essa ação, você terá que sincronizá-los manualmente.",
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
                        this.$store.dispatch('removeFromFacebook').then(() => {
                            swal("Removido!", "Menus removidos com sucesso.", "success")
                            this.$store.dispatch('getMenus')
                        })
                    }
                });
            }
        },
        computed: {
            menus () {
                return this.$store.state.menu.listMenus
            }
        },
        mounted () {
            this.$store.dispatch('getMenus')
        }
    }
</script>
