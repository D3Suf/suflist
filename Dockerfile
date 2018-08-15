FROM tutum/lamp:latest	
#RUN rm -fr /app && git clone https://github.com/D3Suf/suflist.git /app
RUN rm -fr /app
COPY . /app
EXPOSE 80 3306
CMD ["./run.sh"]
