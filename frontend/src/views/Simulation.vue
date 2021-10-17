<template>
  <div class="simulation">
    <b-card
      class="headerTitle"
      header="Simulação de Parcelas"
      text-size="lg"
    >
        <b-form @submit="onSubmit">
          <b-form-group id="input-group-1" class="font-weight-bold" label="Valor do Empréstimo" label-for="input-1"
          >
          <Money v-model="form.valor_emprestimo" class="form-control" @change.native="hideResult"/>
          </b-form-group>
          <b-form-group id="input-group-2" class="font-weight-bold" label="Instituições" label-for="input-2">
            <v-select class="selectMultiple" multiple v-model="form.instituicoes" :options="instituicoes" :reduce="text => text.value" label="text"/>
          </b-form-group>

          <b-form-group id="input-group-3" class="font-weight-bold" label="Convênios" label-for="input-3">
            <v-select class="selectMultiple" multiple v-model="form.convenios" :options="convenios" :reduce="text => text.value" label="text"/>
          </b-form-group>

          <b-form-group id="parcelas" class="font-weight-bold" label="Parcelas" label-for="input-3">
            <b-form-select
              id="input-4"
              v-model="form.parcela"
              :options="tiposParcelas"

            ></b-form-select>
          </b-form-group>

          <b-button type="submit" variant="success">Simular</b-button>
        </b-form>

        <b-card class="mt-3" v-if="showResult">
          <template #header>
            <h6 class="mb-0 text-primary"><b-icon icon="calculator" variant="primary"/> Simulação</h6>
          </template>
          <b-list-group :key="index" v-for="(instituicao, index) in simulacao">
            <b-list-group-item> <h5>{{ index }}</h5>
                <b-list-group :key="index" v-for="(item, index) in instituicao">
                  <b-list-group-item>
                    <h6>
                      <p class="mb-0">Valor Solicitado: R${{ form.valor_emprestimo }}
                      </p>
                      <p class="mb-0 text-success"> Parcelas: {{ item.parcelas }}x de {{ formatPrice(item.valor_parcela) }}
                      </p>
                    </h6>
                    Taxa Juros: {{ item.taxa }} a/m | Convênio: {{ item.convenio }}
                  </b-list-group-item>
                </b-list-group>
            </b-list-group-item>
          </b-list-group>
        </b-card>

    </b-card>
  </div>
</template>

<script>
import config from "../config.ts";
import axios from "axios";
import { Money } from 'v-money'

export default {
  components: { Money },
  data() {
    return {
      form: {
        valor_emprestimo: 0,
        instituicoes: [],
        convenios: [],
        parcela: 0
      },
      simulacao: [],
      convenios: [],
      instituicoes:[],
      tiposParcelas: [{ text: "Todas", value: 0},36, 48, 60, 72, 84],
      showResult: false,
    }
  },
  methods: {
    onSubmit(event) {
      const self = this;
      event.preventDefault()
      axios.post(`${config.apiEndPoint}/api/simular`, this.form).then((response) => {
        self.simulacao = response?.data;
        self.showResult = true;
      });
    },
    onInit(){
      const self = this;
      axios.get(`${config.apiEndPoint}/api/instituicao`).then((response) => {
        response?.data.forEach((item)=> { self.instituicoes.push(self.formatData(item)) });
      });

      axios.get(`${config.apiEndPoint}/api/convenio`).then((response) => {
        response?.data.forEach((item)=> { self.convenios.push(self.formatData(item)) });
      });
    },
    formatData(item){
      return { text: item.valor, value: item.chave};
    },
    formatPrice(price) {
      return price.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
    },
    hideResult(){
      this.showResult = false;
    },
  },
  beforeMount () {
    this.onInit();
  }
}
</script>
<style>
.headerTitle > .card-header {
  font-size: 40px;
  color: #001787;
}

.selectMultiple .vs__selected {
  background: #dfe5fb;
  border: none;
  color: #394066;
}
</style>
