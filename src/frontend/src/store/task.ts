import { defineStore } from 'pinia'
import { ITask } from '@/model/task'
import axios from 'axios';

const apiUrl = 'http://localhost/api'

export const useTaskStore = defineStore('taskStore', {
    state: () => ({
    taskList: [] as ITask[],
    formTask: {
        uuid: '',
        title: '',
        description: '',
        status: 1,
        attachment_url: '',
    } as ITask
  }),
  actions: {
    async getAllTask() {
      this.taskList = await axios.get(apiUrl + '/tasks')
        .then((res) => {
            return res.data.data
        })
    },

    async getTask(uuid: string) {
      this.formTask = await axios.get(apiUrl + '/tasks/' + uuid)
        .then((res) => {
            return res.data.data
        })
    },

    async storeTask(task: ITask) {
        return await axios.post(apiUrl + '/tasks', task)
        .then((res) => {
            return res.data.data
        })
    },

    async deleteTask(uuid: string) {
        return await axios.delete(apiUrl + '/tasks/' + uuid)
        .then((res) => {
            return res.data.data
        })
    },

    appendOrUpdateTask(task: ITask) {
        const i = this.taskList.findIndex(e => e.uuid === task.uuid)
        if (i > -1) this.taskList[i] = task
        else this.taskList.push(task)
    },

    deleteFromStore(uuid: string) {
      this.taskList = this.taskList.filter((item: ITask) => item.uuid !== uuid)
    },

    clearFormCache() {
      this.formTask = {
        uuid: '',
        title: '',
        description: '',
        status: 1,
        attachment_url: '',
      }
    }
  }
})