<style>
    .table-container {
  overflow-x: auto;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th,
td {
  text-align: left;
  padding: 8px;
  border: 1px solid #ddd;
}

@media only screen and (max-width: 600px) {
  th,
  td {
    display: block;
    width: 100%;
  }

  th {
    text-align: center;
  }

  .toggle-table {
    display: block;
  }

  .table-container {
    overflow-x: hidden;
  }

  table {
    border: none;
  }

  tr {
    margin-bottom: 20px;
    display: block;
    border-bottom: 2px solid #ddd;
  }

  td:before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
  }

  td {
    display: block;
    text-align: right;
    border-bottom: 1px dotted #ddd;
  }
}
</style>

<div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Header 1</th>
          <th>Header 2</th>
          <th>Header 3</th>
          <th>Header 4</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Data 1</td>
          <td>Data 2</td>
          <td>Data 3</td>
          <td>Data 4</td>
        </tr>
        <tr>
          <td>Data 5</td>
          <td>Data 6</td>
          <td>Data 7</td>
          <td>Data 8</td>
        </tr>
      </tbody>
    </table>
  </div>
  <button class="toggle-table">Show/Hide Table</button>

  <script>
    const toggleTableButton = document.querySelector('.toggle-table');
const tableContainer = document.querySelector('.table-container');

toggleTableButton.addEventListener('click', function() {
  tableContainer.classList.toggle('table-hidden');
});
  </script>
