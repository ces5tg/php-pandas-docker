from flask import Flask, jsonify, request, send_file
import plotly.express as px
import plotly.io as pio
import plotly.graph_objs as go
import matplotlib.pyplot as plt
import seaborn as sns
import os
import pandas as pd
import io
import redis
app = Flask(__name__)
redis_conn = redis.from_url(os.getenv("REDIS_URL", "redis://localhost:6379"))

@app.route('/', methods=['GET', 'POST'])
def upload_form():
    if request.method == 'POST':
        file = request.files['file']
        if file:
            # Aquí puedes procesar el archivo si es necesario
            return upload()

    return '''
    <!doctype html>
    <title>Subir archivo CSV</title>
    <h1>Subir archivo CSV</h1>
    <form method=post enctype=multipart/form-data>
      <input type=file name=file>
      <input type=submit value=Upload>
    </form>
    '''

@app.route('/upload', methods=['POST'])
def upload():
    if 'file' not in request.files:
        return jsonify({"error": "No file part"})

    file = request.files['file']

    if file.filename == '':
        return jsonify({"error": "No selected file"})

    if file:
        # Cargar el archivo CSV en un DataFrame de pandas
        fifa20 = pd.read_csv(file)

        

    fifa20_3 = fifa20[["age", "height_cm", "weight_kg", "overall", "potential", "value_eur", "wage_eur",
                           "power_jumping", "power_long_shots", "skill_moves", "shooting", "passing", "dribbling",
                           "mentality_vision", "movement_agility"]]

    # Calcular la matriz de correlación
    corr = fifa20_3.corr()

    # Crear un mapa de calor con Seaborn
    plt.figure(figsize=(10, 8))
    sns.heatmap(corr, annot=True, cmap='coolwarm', fmt=".2f")

    # Guardar la figura en un buffer de bytes
    img_buf = io.BytesIO()
    plt.savefig(img_buf, format='png')
    img_buf.seek(0)
    plt.close()

    # Retornar el contenido binario de la imagen y su tipo MIME
    return send_file(img_buf, mimetype='image/png')

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000, debug=True)








