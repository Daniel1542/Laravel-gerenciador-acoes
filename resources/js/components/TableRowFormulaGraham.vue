<!-- resources/js/components/TableRow.vue -->
<template>
    <tr>
      <td>{{ row.ticker }}</td>
      <td>{{ row.lpa }}</td>
      <td>{{ row.vpa }}</td>
      <td>R$ {{ formattedPrecoJusto }}</td>
      <td class="buttons">
        <form :action="`/graham/${row.id}/edit`" method="GET">
          <input type="hidden" name="_token" :value="csrfToken" />
          <button type="submit" class="btn btn-warning">Editar</button>
        </form>
        <form :action="`/graham/${row.id}/delete`" method="POST" @submit.prevent="confirmDelete">
          <input type="hidden" name="_token" :value="csrfToken" />
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Excluir</button>
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
      data() {
        return {
          csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
      },
      computed: {
        
        formattedPrecoJusto() {
            return Number(this.row.preco_justo).toFixed(2);
        }
      },
      methods: {
        confirmDelete(event) {
            if (confirm('Tem certeza que deseja excluir?')) {
              event.target.closest('form').submit();
            }
        }
      }
  }
</script>