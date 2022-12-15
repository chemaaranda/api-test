
  const validJSON = (obj) => {
    let valid = true
    try {
        JSON.parse(obj)
    } catch (error) {
      valid = false
    }
    return valid
  }
  
  export { validJSON }; 