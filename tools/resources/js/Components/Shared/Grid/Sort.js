import NProgress from 'nprogress'
import { router } from '@inertiajs/vue3'

export default function Sort(emit) {
    const flash = (keyIn, value) => {
        emit('updateFlash', [keyIn, value])
    }

    let sortColumns = []
    let sortOrders = []

    const setSort = (columns, orders) => {
        sortColumns = columns
        sortOrders = orders
    }

    const addColumnToSort = (columnName, url, queryString) => {
        let valIndex = sortColumns.indexOf(columnName)
        if(valIndex > -1) {
            sortOrders[valIndex] = sortOrders[valIndex] === 'asc' ? 'desc' : 'asc'
        } else {
            sortColumns.push(columnName)
            sortOrders.push('asc')
        }

        let sortQueryString = getSortQuerystring()
        let combinedQuery = {...queryString, ...sortQueryString}

        router.get(url, combinedQuery, { preserveState: false })
    }

    const getSortQuerystring = () => {
        if (sortColumns.length < 1) return {}

        return {
            sort_columns: Object.assign({}, sortColumns),
            sort_orders: Object.assign({}, sortOrders)
        }
    }

    const resetSort = (url, queryString) => {
        sortColumns = []
        sortOrders = []
        router.get(url, queryString, {
            onStart: () => NProgress.start(),
            onFinish: () => NProgress.done(),
        })
    }


    const sortOrder = (columnName) => {
        let valIndex = sortColumns.indexOf(columnName)
        return sortOrders[valIndex]
    }

    return {sortColumns, sortOrders, setSort, addColumnToSort, resetSort, sortOrder, getSortQuerystring, }
}