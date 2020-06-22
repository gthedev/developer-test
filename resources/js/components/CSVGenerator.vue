<template>
    <div class="container">
        <div id="csv-generator">
            <table class="table table-striped" ref="table">
                <thead>
                <tr>
                    <th v-for="(column, columnIndex) in columns">
                        <div class="row">
                            <div class="col-10">
                                <input type="text"
                                       class="form-control"
                                       v-model="column.key"
                                />
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn text-danger btn-sm btn-round float-right" tabindex="-1"
                                        @click="removeColumn(columnIndex)"
                                        title="Remove column"
                                >
                                    <b-icon icon="trash"></b-icon>
                                </button>
                            </div>
                        </div>
                    </th>
                    <th class="text-center">
                        <button type="button" class="btn btn-success btn-sm btn-round" @click="addColumn"
                                tabindex="-1"
                                title="Add new column"
                        >
                            <b-icon icon="plus"></b-icon>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row, rowIndex) in rows" :key="`row-${rowIndex}`">
                    <td v-for="(column, columnIndex) in columns">
                        <input type="text" class="form-control" v-model="row[columnIndex]"
                               v-b-tooltip.focus
                               :title="column.key"
                        />
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn text-danger btn-sm btn-round"
                                tabindex="-1"
                                @click="removeRow(rowIndex)"
                                title="Delete row"
                        >
                            <b-icon icon="trash"></b-icon>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center">
                <button type="button" class="btn btn-success btn-sm btn-round" @click="addRow">
                    <b-icon icon="plus"></b-icon>
                    Add new row
                </button>
            </div>

            <div class="well mt-5 mb-4">
                <strong>Generator Options</strong>
                <hr/>
                <label>
                    <input type="checkbox" v-model="options.includeHeadings"/>
                    Include headings
                </label>
            </div>

            <button class="btn btn-primary btn-block btn-round btn-lg" type="button" @click="submit()"
                    :disabled="loading">
                <template v-if="loading">
                    <b-spinner></b-spinner>
                </template>
                <template v-else>
                    Export
                </template>
            </button>
        </div>
    </div>
</template>

<script>
    import FileSaver from 'file-saver';

    export default {
        name: "CSVGenerator",

        data() {
            return {
                loading: false,

                rows: [
                    ['John', 'Doe', 'john.doe@example.com'],
                ],
                columns: [
                    {key: 'First Name'},
                    {key: 'Last Name'},
                    {key: 'Email'},
                ],

                options: {
                    includeHeadings: true,
                }
            }
        },

        computed: {
            headings() {
                return this.columns.map(c => c.key);
            }
        },

        methods: {
            addRow() {
                this.rows.push([]);

                this.$nextTick(() => this.focusOnLastRow());
            },

            focusOnLastRow() {
                this.$refs.table.querySelector('tbody tr:last-child td:first-child input').focus();
            },

            removeRow(rowIndex) {
                this.rows.splice(rowIndex, 1);
            },

            addColumn() {
                this.columns.push({key: 'Column Name'});
            },

            removeColumn(columnIndex) {
                this.columns.splice(columnIndex, 1);

                // Tidy up the data
                this.rows = this.rows.map(row => {
                    if (row.length >= columnIndex - 1) {
                        row.splice(columnIndex, 1);
                    }

                    return row;
                });
            },

            submit() {
                this.loading = true;

                let data = {
                    headings: this.columns.map(c => c.key),
                    rows: this.rows,
                    options: this.options,
                };

                axios.post('/api/csv-export', data)
                    .then(({data}) => {
                        this.downloadDataAsCSV(data);
                    })
                    .catch(error => {
                        console.error(error);

                        // @todo here we can (1) add nicer alert, like Toasted and (2) extract actual message depending on what errors we can realistically expect
                        alert('Something went wrong! Please try again');
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },

            downloadDataAsCSV(data) {
                FileSaver.saveAs(new Blob([data], {type: "text/csv"}), "csv-export.csv");
            }
        },
    }
</script>

<style scoped lang="scss">

</style>
