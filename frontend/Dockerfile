FROM node:13

RUN apt-get update
#RUN npm install --global yarn

RUN mkdir /app
WORKDIR /app

#COPY ./package.json /app
#COPY ./yarn.lock /app
COPY . /app

RUN npm install
RUN npm run build

EXPOSE 5000

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=5000

CMD ["npm", "start"]
