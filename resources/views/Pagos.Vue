<template>
  <div>
    <h1>Gestión de Pagos</h1>
    <form @submit.prevent="crearPago">
      <select v-model="nuevoPago.cliente_id">
        <option disabled value="">Selecciona un cliente</option>
        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
          {{ cliente.nombre }}
        </option>
      </select>

      <select v-model="nuevoPago.pedido_id">
        <option disabled value="">Selecciona un pedido</option>
        <option v-for="pedido in pedidos" :key="pedido.id" :value="pedido.id">
          Pedido #{{ pedido.id }}
        </option>
      </select>

      <input v-model="nuevoPago.monto" type="number" placeholder="Monto" />
      <select v-model="nuevoPago.metodo_pago">
        <option disabled value="">Selecciona el método de pago</option>
        <option value="efectivo">Efectivo</option>
        <option value="tarjeta">Tarjeta</option>
        <option value="paypal">PayPal</option>
      </select>

      <button type="submit">Crear Pago</button>
    </form>

    <ul>
      <li v-for="pago in pagos" :key="pago.id">
        Pago #{{ pago.id }} - {{ pago.cliente.nombre }} - ${{ pago.monto }} - {{ pago.metodo_pago }}
        <button @click="eliminarPago(pago.id)">Eliminar</button>
        <button @click="editarPago(pago)">Editar</button>
      </li>
    </ul>

    <!-- Modal para editar pago -->
    <div v-if="pagoEditado" class="modal">
      <h2>Editar Pago</h2>
      <form @submit.prevent="actualizarPago">
        <select v-model="pagoEditado.cliente_id">
          <option disabled value="">Selecciona un cliente</option>
          <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
            {{ cliente.nombre }}
          </option>
        </select>

        <select v-model="pagoEditado.pedido_id">
          <option disabled value="">Selecciona un pedido</option>
          <option v-for="pedido in pedidos" :key="pedido.id" :value="pedido.id">
            Pedido #{{ pedido.id }}
          </option>
        </select>

        <input v-model="pagoEditado.monto" type="number" placeholder="Monto" />
        <select v-model="pagoEditado.metodo_pago">
          <option value="efectivo">Efectivo</option>
          <option value="tarjeta">Tarjeta</option>
          <option value="paypal">PayPal</option>
        </select>

        <button type="submit">Actualizar Pago</button>
        <button @click="pagoEditado = null">Cancelar</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      pagos: [],
      clientes: [],
      pedidos: [],
      nuevoPago: {
        cliente_id: "",
        pedido_id: "",
        monto: "",
        metodo_pago: "",
      },
      pagoEditado: null,
    };
  },
  methods: {
    obtenerPagos() {
      axios.get("/api/pagos").then((response) => {
        this.pagos = response.data;
      });
    },
    obtenerClientes() {
      axios.get("/api/clientes").then((response) => {
        this.clientes = response.data;
      });
    },
    obtenerPedidos() {
      axios.get("/api/pedidos").then((response) => {
        this.pedidos = response.data;
      });
    },
    crearPago() {
      axios.post("/api/pagos", this.nuevoPago).then((response) => {
        this.pagos.push(response.data);
        this.nuevoPago = {
          cliente_id: "",
          pedido_id: "",
          monto: "",
          metodo_pago: "",
        };
      });
    },
    eliminarPago(id) {
      axios.delete(`/api/pagos/${id}`).then(() => {
        this.pagos = this.pagos.filter((pago) => pago.id !== id);
      });
    },
    editarPago(pago) {
      this.pagoEditado = { ...pago };
    },
    actualizarPago() {
      axios.put(`/api/pagos/${this.pagoEditado.id}`, this.pagoEditado).then((response) => {
        const index = this.pagos.findIndex((pago) => pago.id === this.pagoEditado.id);
        this.pagos.splice(index, 1, response.data);
        this.pagoEditado = null;
      });
    },
  },
  mounted() {
    this.obtenerPagos();
    this.obtenerClientes();
    this.obtenerPedidos();
  },
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
form {
  background: white;
  padding: 20px;
  border-radius: 5px;
}
</style>
