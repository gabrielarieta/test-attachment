FROM node:20 as build-stage

WORKDIR /app
COPY ./src/frontend/package.json .

RUN npm install
COPY ./src/frontend .

RUN npm run build

FROM nginx as production-stage
EXPOSE 3000
RUN mkdir /app
COPY docker/frontend/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=build-stage /app/dist /app
