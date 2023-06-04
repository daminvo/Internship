<template>
  <div id="app">
      <h2>Download File in Vue Js using Axios</h2>

      <button @click="downloadFile()">DownLoad</button>
  </div>
</template>


<script>
    import axios from 'axios';

    export default {
      mounted() {
          this.downloadFile();
      },
      methods: {
          downloadFile() {
              axios({
                    url: 'http://localhost:8000/demo.pdf', // File URL Goes Here
                    method: 'GET',
                    responseType: 'blob',
                }).then((res) => {
                     var FILE = window.URL.createObjectURL(new Blob([res.data]));

                     var docUrl = document.createElement('x');
                     docUrl.href = FILE;
                     docUrl.setAttribute('download', 'file.pdf');
                     document.body.appendChild(docUrl);
                     docUrl.click();
                });
          }
      }
    }
</script>
