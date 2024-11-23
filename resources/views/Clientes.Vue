<template>
  <div>
    <h1>Gestión de Clientes</h1>
    <form @submit.prevent="crearCliente">
      <input v-model="nuevoCliente.nombre" placeholder="Nombre" />
      <input v-model="nuevoCliente.email" type="email" placeholder="Email" />
      <input v-model="nuevoCliente.telefono" placeholder="Teléfono" />
      <input v-model="nuevoCliente.direccion" placeholder="Dirección" />
      <button type="submit">Crear Cliente</button>
    </form>

    <ul>
      <li v-for="cliente in clientes" :key="cliente.id">
        {{ cliente.nombre }} - {{ cliente.email }}
        <button @click="eliminarCliente(cliente.id)">Eliminar</button>
        <button @click="editarCliente(cliente)">Editar</button>
      </li>
    </ul>

    <!-- Modal para editar cliente -->
    <div v-if="clienteEditado" class="modal">
      <h2>Editar Cliente</h2>
      <form @submit.prevent="actualizarCliente">
        <input v-model="clienteEditado.nombre" placeholder="Nombre" />
        <input v-model="clienteEditado.email" type="email" placeholder="Email" />
        <input v-model="clienteEditado.telefono" placeholder="Teléfono" />
        <input v-model="clienteEditado.direccion" placeholder="Dirección" />
        <button type="submit">Actualizar Cliente</button>
        <button @click="clienteEditado = null">Cancelar</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      clientes: [],
      nuevoCliente: {
        nombre: "",
        email: "",
        telefono: "",
        direccion: "",
      },
      clienteEditado: null,
    };
  },
  methods: {
    obtenerClientes() {
      axios.get("/api/clientes").then((response) => {
        this.clientes = response.data;
      });
    },
    crearCliente() {
      axios.post("/api/clientes", this.nuevoCliente).then((response) => {
        this.clientes.push(response.data);
        this.nuevoCliente = {
          nombre: "",
          email: "",
          telefono: "",
          direccion: "",
        };
      });
    },
    eliminarCliente(id) {
      axios.delete(`/api/clientes/${id}`).then(() => {
        this.clientes = this.clientes.filter((cliente) => cliente.id !== id);
      });
    },
    editarCliente(cliente) {
      this.clienteEditado = { ...cliente };
    },
    actualizarCliente() {
      axios.put(`/api/clientes/${this.clienteEditado.id}`, this.clienteEditado).then((response) => {
        const index = this.clientes.findIndex(cliente => cliente.id === this.clienteEditado.id);
        this.clientes.splice(index, 1, response.data);
        this.clienteEditado = null;
      });
    },
  },
  mounted() {
    this.obtenerClientes();
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
