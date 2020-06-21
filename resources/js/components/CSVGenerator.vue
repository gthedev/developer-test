<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Table to CSV Generator</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th v-for="(column, columnIndex) in columns">
                                    <input type="text"
                                           class="form-control"
                                           v-model="column.key"
                                    />

                                    <button type="button" class="btn btn-danger btn-sm" tabindex="-1"
                                            @click="removeColumn(columnIndex)">
                                        remove column
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, rowIndex) in rows">
                                <td v-for="(columnName, columnIndex) in columns">
                                    <input type="text" class="form-control" v-model="row[columnIndex]"/>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            tabindex="-1"
                                            @click="removeRow(rowIndex)">
                                        remove row
                                    </button>
                                </td>
                            </tr>
                            </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-secondary" @click="addColumn">Add Column</button>
                        <button type="button" class="btn btn-secondary" @click="addRow">Add Row</button>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary" type="button" @click="submit()">Export</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "CSVGenerator",

        data() {
            return {
                rows: [
                    ['John', 'Doe', 'john.doe@example.com'],
                    ['John 2', 'Doe 2'],
                ],
                columns: [
                    {key: 'firstName'},
                    {key: 'lastName'},
                    {key: 'emailAddress'},
                ]
            }
        },

        methods: {
            addRow() {
                this.rows.push([]);
            },

            removeRow(rowIndex) {
                this.rows.splice(rowIndex, 1);
            },

            addColumn() {
                this.columns.push({key: ''});
            },

            removeColumn(columnIndex) {
                this.columns.splice(columnIndex, 1);
            },

            submit() {
                return axios.patch('/api/csv-export', this.data);
            }
        },
    }
</script>

<style scoped>

</style>
