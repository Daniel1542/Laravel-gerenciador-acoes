<!-- resources/js/components/TableRow.vue -->
<template>
    <tr>
      <td>{{ row.ticker }}</td>
      <td>{{ row.lpa }}</td>
      <td>{{ row.payout }} %</td>
      <td>{{ formattedDpa }}</td>
      <td>{{ row.yield_projetado }} %</td>
      <td>R$ {{ formattedPrecoTeto }}</td>
      <td class="buttons">
        <form :action="`/formula/editBazin/${row.id}`" method="GET">
          <button type="submit" class="btn btn-warning">Editar</button>
        </form>
        <form :action="`/formula/destroyBazin/${row.id}`" method="POST">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger" @click.prevent="confirmDelete">Excluir</button>
        </form>
      </td>
    </tr>
</template>
  
<script>
export default {
    props: {
    row: {
        type: Object,
        required: true
    }
    },
    computed: {
    formattedDpa() {
        return Number(this.row.dpa).toFixed(2);
    },
    formattedPrecoTeto() {
        return Number(this.row.preco_teto).toFixed(2);
    }
    },
    methods: {
    confirmDelete(event) {
        if (confirm('Tem certeza que deseja excluir?')) {
        event.target.form.submit();
        }
    }
    }
}
</script>
  